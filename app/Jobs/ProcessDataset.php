<?php

namespace App\Jobs;

use App\Models\Dataset;
use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessDataset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataset;

    /**
     * The number of seconds the job can run before timing out.
     */
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(Dataset $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("Processing dataset {$this->dataset->id} of type {$this->dataset->type}");

            $filePath = storage_path('app/'.$this->dataset->file_path);

            if (! file_exists($filePath)) {
                throw new \Exception('Dataset file not found');
            }

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            // Remove header row
            $headers = array_shift($data);

            // Process based on type
            switch ($this->dataset->type) {
                case 'sales':
                    $this->processSalesData($data);
                    break;
                case 'menu':
                    $this->processMenuData($data);
                    break;
                case 'inventory':
                    $this->processInventoryData($data);
                    break;
                case 'customers':
                    $this->processCustomerData($data);
                    break;
            }

            // Mark as completed
            $this->dataset->update([
                'status' => 'completed',
                'processed_at' => now(),
                'processing_notes' => 'Successfully processed '.count($data).' records',
            ]);

            Log::info("Dataset {$this->dataset->id} processed successfully");

        } catch (\Exception $e) {
            Log::error("Failed to process dataset {$this->dataset->id}: ".$e->getMessage());

            $this->dataset->update([
                'status' => 'failed',
                'validation_errors' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Process sales data
     */
    private function processSalesData($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                if (empty($row[0])) {
                    continue;
                } // Skip empty rows

                // Check if order already exists
                $existingOrder = Order::where('restaurant_id', $this->dataset->restaurant_id)
                    ->where('order_number', $row[0])
                    ->first();

                if ($existingOrder) {
                    continue; // Skip duplicates
                }

                // Create order
                $order = Order::create([
                    'restaurant_id' => $this->dataset->restaurant_id,
                    'order_number' => $row[0],
                    'customer_name' => $row[3] ?? 'Guest',
                    'order_date' => $row[1] ?? now(),
                    'order_time' => $row[2] ?? now()->format('H:i:s'),
                    'total_amount' => $row[7] ?? 0,
                    'payment_method' => $row[8] ?? 'cash',
                    'status' => $row[9] ?? 'completed',
                    'dataset_id' => $this->dataset->id,
                ]);

                // Find or create menu item
                $menuItem = MenuItem::firstOrCreate(
                    [
                        'restaurant_id' => $this->dataset->restaurant_id,
                        'name' => $row[4],
                    ],
                    [
                        'category_id' => null,
                        'price' => $row[6] ?? 0,
                        'cost' => 0,
                        'is_active' => true,
                    ]
                );

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $row[5] ?? 1,
                    'unit_price' => $row[6] ?? 0,
                    'subtotal' => $row[7] ?? 0,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process menu data
     */
    private function processMenuData($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                if (empty($row[0])) {
                    continue;
                }

                MenuItem::updateOrCreate(
                    [
                        'restaurant_id' => $this->dataset->restaurant_id,
                        'name' => $row[1],
                    ],
                    [
                        'category_id' => null, // Would need to map category
                        'description' => $row[3] ?? '',
                        'price' => $row[4] ?? 0,
                        'cost' => $row[5] ?? 0,
                        'is_active' => ($row[6] ?? 'active') === 'active',
                        'prep_time_minutes' => $row[8] ?? null,
                        'dataset_id' => $this->dataset->id,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process inventory data
     */
    private function processInventoryData($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                if (empty($row[0])) {
                    continue;
                }

                InventoryItem::updateOrCreate(
                    [
                        'restaurant_id' => $this->dataset->restaurant_id,
                        'name' => $row[0],
                    ],
                    [
                        'category' => $row[1] ?? 'General',
                        'unit' => $row[2] ?? 'unit',
                        'current_stock' => $row[3] ?? 0,
                        'minimum_stock' => $row[4] ?? 0,
                        'unit_cost' => $row[5] ?? 0,
                        'supplier' => $row[6] ?? null,
                        'last_updated' => $row[7] ?? now(),
                        'dataset_id' => $this->dataset->id,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Process customer data
     */
    private function processCustomerData($data)
    {
        // For now, we'll just log this as we don't have a Customer model yet
        Log::info('Customer data processing not yet implemented. Records: '.count($data));
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Dataset processing job failed: '.$exception->getMessage());

        $this->dataset->update([
            'status' => 'failed',
            'validation_errors' => $exception->getMessage(),
        ]);
    }
}
