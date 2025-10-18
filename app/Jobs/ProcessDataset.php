<?php

namespace App\Jobs;

use App\Models\Dataset;
use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\WeatherService;
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
     * Increased to accommodate weather data fetching with delays.
     */
    public $timeout = 600;

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
                    Log::info("Processing sales data for dataset {$this->dataset->id}");
                    $this->processSalesData($data);
                    Log::info('Finished processing sales data, now fetching weather data...');
                    // Fetch weather data for sales orders
                    $this->fetchWeatherDataForOrders();
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
            // Group data by order_no to handle multiple items per order
            $groupedData = [];
            foreach ($data as $row) {
                if (empty($row[0])) {
                    continue; // Skip empty rows
                }
                $orderNo = $row[0];
                if (! isset($groupedData[$orderNo])) {
                    $groupedData[$orderNo] = [];
                }
                $groupedData[$orderNo][] = $row;
            }

            foreach ($groupedData as $orderNo => $rows) {
                // Check if order already exists
                $existingOrder = Order::where('restaurant_id', $this->dataset->restaurant_id)
                    ->where('order_no', $orderNo)
                    ->first();

                if ($existingOrder) {
                    // If order exists, check if it already has items from this dataset
                    $existingItemCount = OrderItem::where('order_id', $existingOrder->id)
                        ->whereHas('order', function ($q) {
                            $q->where('dataset_id', $this->dataset->id);
                        })
                        ->count();

                    if ($existingItemCount > 0) {
                        continue; // Skip if already processed
                    }
                }

                // Calculate totals from all items in this order
                $totalGross = 0;
                $firstRow = $rows[0]; // Use first row for order-level data

                foreach ($rows as $row) {
                    $totalGross += $row[7] ?? 0; // total_amount per item
                }

                // Parse and format datetime properly
                $orderDateTime = $this->parseDateTime($firstRow[1] ?? null, $firstRow[2] ?? null);

                // Create or update order
                $order = Order::updateOrCreate(
                    [
                        'restaurant_id' => $this->dataset->restaurant_id,
                        'order_no' => $orderNo,
                    ],
                    [
                        'customer_name' => $firstRow[3] ?? 'Guest',
                        'order_dt' => $orderDateTime,
                        'gross_amount' => $totalGross,
                        'net_amount' => $totalGross, // Assuming no discounts for now
                        'payment_method' => $firstRow[8] ?? 'cash',
                        'status' => $firstRow[9] ?? 'completed',
                        'dataset_id' => $this->dataset->id,
                    ]
                );

                // Create order items for each row
                foreach ($rows as $row) {
                    // Find or create menu item
                    $menuItem = MenuItem::firstOrCreate(
                        [
                            'restaurant_id' => $this->dataset->restaurant_id,
                            'name' => $row[4],
                        ],
                        [
                            'sku' => 'AUTO_'.strtoupper(str_replace(' ', '_', $row[4])),
                            'category_id' => null,
                            'price' => $row[6] ?? 0,
                            'cogs' => 0,
                            'is_active' => true,
                            'dataset_id' => $this->dataset->id,
                        ]
                    );

                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $menuItem->id,
                        'qty' => $row[5] ?? 1,
                        'unit_price' => $row[6] ?? 0,
                        'line_total' => $row[7] ?? 0,
                    ]);
                }
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
                        'sku' => $row[0],
                    ],
                    [
                        'name' => $row[1],
                        'category_id' => null, // Would need to map category from $row[2]
                        'description' => $row[3] ?? '',
                        'price' => $row[4] ?? 0,
                        'cogs' => $row[5] ?? 0,
                        'is_active' => ($row[6] ?? 'active') === 'active',
                        'prep_time_minutes' => $row[8] ?? 0,
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
                        'sku' => 'INV_'.strtoupper(str_replace(' ', '_', $row[0])),
                    ],
                    [
                        'name' => $row[0],
                        'description' => $row[1] ?? 'General',
                        'uom' => $row[2] ?? 'unit',
                        'current_stock' => $row[3] ?? 0,
                        'safety_stock' => $row[4] ?? 0,
                        'unit_cost' => $row[5] ?? 0,
                        'supplier' => $row[6] ?? null,
                        'is_active' => true,
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
     * Parse datetime from Excel/CSV data with various formats
     */
    private function parseDateTime($dateValue, $timeValue = null)
    {
        try {
            // If date is empty, use current datetime
            if (empty($dateValue)) {
                return \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            }

            // Handle Excel date number format
            if (is_numeric($dateValue)) {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue);
                $dateString = $date->format('Y-m-d');
            } else {
                // Handle string date formats like "1/15/2024", "2024-01-15", etc.
                $date = \DateTime::createFromFormat('m/d/Y', $dateValue);
                if (! $date) {
                    $date = \DateTime::createFromFormat('Y-m-d', $dateValue);
                }
                if (! $date) {
                    $date = \DateTime::createFromFormat('d/m/Y', $dateValue);
                }
                if (! $date) {
                    // Try generic date parsing
                    $date = date_create($dateValue);
                }

                if (! $date) {
                    throw new \Exception("Could not parse date: {$dateValue}");
                }

                $dateString = $date->format('Y-m-d');
            }

            // Handle time component
            if (! empty($timeValue)) {
                // Parse time value
                if (is_numeric($timeValue)) {
                    // Excel time format
                    $timeObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($timeValue);
                    $timeString = $timeObj->format('H:i:s');
                } else {
                    // String time format like "12:30:00" or "12:30"
                    $timeObj = \DateTime::createFromFormat('H:i:s', $timeValue);
                    if (! $timeObj) {
                        $timeObj = \DateTime::createFromFormat('H:i', $timeValue);
                    }
                    if (! $timeObj) {
                        // Default to current time if parsing fails
                        $timeString = \Carbon\Carbon::now()->format('H:i:s');
                    } else {
                        $timeString = $timeObj->format('H:i:s');
                    }
                }

                return $dateString.' '.$timeString;
            } else {
                // No time component, use default time
                return $dateString.' 00:00:00';
            }

        } catch (\Exception $e) {
            Log::warning("Date parsing failed for '{$dateValue}' '{$timeValue}': ".$e->getMessage());

            return \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        }
    }

    /**
     * Fetch weather data for all orders from this dataset
     */
    private function fetchWeatherDataForOrders()
    {
        try {
            Log::info("Starting weather data fetch for dataset {$this->dataset->id}");

            // Get restaurant coordinates
            $restaurant = $this->dataset->restaurant;
            if (! $restaurant || ! $restaurant->latitude || ! $restaurant->longitude) {
                Log::warning("Restaurant coordinates not available for dataset {$this->dataset->id}. Skipping weather fetch.");

                return;
            }

            $lat = $restaurant->latitude;
            $lon = $restaurant->longitude;
            Log::info("Restaurant coordinates: lat={$lat}, lon={$lon}");

            // Get all orders from this dataset that don't have weather data yet
            $orders = Order::where('dataset_id', $this->dataset->id)
                ->whereNull('weather_fetched_at')
                ->orderBy('order_dt')
                ->get();

            Log::info("Found {$orders->count()} orders without weather data for dataset {$this->dataset->id}");

            if ($orders->isEmpty()) {
                Log::info("No orders need weather data for dataset {$this->dataset->id}");

                return;
            }

            Log::info("Order date range: {$orders->first()->order_dt} to {$orders->last()->order_dt}");

            $weatherService = new WeatherService;

            // Group orders by time windows (150 hours = 6.25 days)
            // We'll fetch weather in batches starting from the earliest order time
            $earliestOrder = $orders->first();
            $latestOrder = $orders->last();

            $currentStart = strtotime($earliestOrder->order_dt);
            $endTime = strtotime($latestOrder->order_dt);

            $weatherData = [];
            $fetchCount = 0;

            // Fetch weather data in chunks of 150 hours
            while ($currentStart <= $endTime) {
                $startDateTime = date('Y-m-d H:i:s', $currentStart);
                Log::info("Fetching weather data starting from {$startDateTime}");

                // Fetch weather data for this time window
                $response = $weatherService->getHistoricalWeatherFromOpenWeatherMapByCoords($lat, $lon, $currentStart);

                if (! isset($response['error']) && isset($response['list'])) {
                    // Store weather data indexed by timestamp
                    foreach ($response['list'] as $weather) {
                        $weatherData[$weather['dt']] = $weather;
                    }
                    Log::info('Fetched '.count($response['list']).' weather records');
                } else {
                    $error = $response['error'] ?? 'Unknown error';
                    Log::warning("Failed to fetch weather data: {$error}");
                    Log::debug('Weather API response: '.json_encode($response));
                }

                $fetchCount++;

                // Move to next time window (150 hours ahead)
                $currentStart += (150 * 3600);

                // Add 5 second delay between API calls to prevent spam detection
                if ($currentStart <= $endTime) {
                    Log::info('Waiting 5 seconds before next API call...');
                    sleep(5);
                }
            }

            Log::info("Completed weather data fetch. Made {$fetchCount} API calls. Retrieved ".count($weatherData).' weather records.');

            if (empty($weatherData)) {
                Log::warning('No weather data was retrieved from the API. Cannot update orders.');

                return;
            }

            // Now match weather data to orders
            $updatedCount = 0;
            $failedCount = 0;
            $notFoundCount = 0;

            Log::info("Starting to match weather data to {$orders->count()} orders...");

            foreach ($orders as $order) {
                $orderTimestamp = strtotime($order->order_dt);

                // Find the closest weather data (within 1 hour)
                $closestWeather = null;
                $minDiff = PHP_INT_MAX;

                foreach ($weatherData as $timestamp => $weather) {
                    $diff = abs($timestamp - $orderTimestamp);
                    if ($diff < $minDiff && $diff <= 3600) { // Within 1 hour
                        $minDiff = $diff;
                        $closestWeather = $weather;
                    }
                }

                if ($closestWeather) {
                    try {
                        // Validate weather data structure
                        if (! isset($closestWeather['main']) || ! isset($closestWeather['weather'])) {
                            Log::error("Invalid weather data structure for order {$order->id}", [
                                'weather_data' => $closestWeather,
                            ]);
                            $failedCount++;

                            continue;
                        }

                        // Log the weather data we're about to save
                        $weatherToSave = [
                            'weather_temp' => $closestWeather['main']['temp'] ?? null,
                            'weather_condition' => $closestWeather['weather'][0]['main'] ?? null,
                            'weather_description' => $closestWeather['weather'][0]['description'] ?? null,
                            'weather_humidity' => $closestWeather['main']['humidity'] ?? null,
                            'weather_pressure' => $closestWeather['main']['pressure'] ?? null,
                            'weather_wind_speed' => $closestWeather['wind']['speed'] ?? null,
                            'weather_fetched_at' => now(),
                        ];

                        Log::info("Updating order {$order->id} (order_no: {$order->order_no}, order_dt: {$order->order_dt}) with weather data", [
                            'weather_data' => $weatherToSave,
                            'time_diff_seconds' => $minDiff,
                        ]);

                        // Update order with weather data
                        $updateResult = $order->update($weatherToSave);

                        if ($updateResult) {
                            $updatedCount++;
                            Log::debug("Successfully updated order {$order->id} with weather data");
                        } else {
                            $failedCount++;
                            Log::error("Failed to update order {$order->id} with weather data - update() returned false");
                        }
                    } catch (\Exception $e) {
                        $failedCount++;
                        Log::error("Exception while updating order {$order->id} with weather data: ".$e->getMessage(), [
                            'exception' => $e,
                            'order_id' => $order->id,
                            'order_dt' => $order->order_dt,
                        ]);
                    }
                } else {
                    $notFoundCount++;
                    Log::warning("No weather data found for order {$order->id} (order_no: {$order->order_no}) at {$order->order_dt}");
                }
            }

            Log::info("Weather data update summary for dataset {$this->dataset->id}: Updated={$updatedCount}, Failed={$failedCount}, NotFound={$notFoundCount}, Total={$orders->count()}");

        } catch (\Exception $e) {
            Log::error("Failed to fetch weather data for dataset {$this->dataset->id}: ".$e->getMessage());
            // Don't throw exception - weather data is supplementary, not critical
        }
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
