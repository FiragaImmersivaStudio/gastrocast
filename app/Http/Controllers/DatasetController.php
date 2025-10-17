<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDataset;
use App\Models\Dataset;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DatasetController extends Controller
{
    /**
     * Display dataset management page
     */
    public function index()
    {
        $restaurantId = session('selected_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('dashboard')->with('error', 'Please select a restaurant first');
        }

        $datasets = Dataset::where('restaurant_id', $restaurantId)
            ->with('uploadedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('datasets.index', compact('datasets'));
    }

    /**
     * Upload a new dataset
     */
    public function upload(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sales,customers,menu,inventory',
            'file' => 'required|file|mimes:xlsx|max:10240', // Max 10MB
        ]);

        $restaurantId = session('selected_restaurant_id');
        if (! $restaurantId) {
            return response()->json(['error' => 'No restaurant selected'], 400);
        }

        $file = $request->file('file');
        $type = $request->type;

        try {
            // Validate the file structure
            $validationResult = $this->validateDatasetStructure($file, $type);

            if (! $validationResult['valid']) {
                return response()->json([
                    'error' => 'Invalid file structure',
                    'details' => $validationResult['errors'],
                ], 422);
            }

            // Store the file
            $filename = $type.'_'.time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('datasets', $filename, 'local');

            // Create dataset record
            $dataset = Dataset::create([
                'restaurant_id' => $restaurantId,
                'uploaded_by' => Auth::id(),
                'type' => $type,
                'filename' => $filename,
                'file_path' => $path,
                'total_records' => $validationResult['total_records'],
                'data_start_date' => $validationResult['start_date'],
                'data_end_date' => $validationResult['end_date'],
                'status' => 'uploaded',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dataset uploaded successfully',
                'dataset' => $dataset,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload dataset',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process a dataset
     */
    public function process($id)
    {
        $dataset = Dataset::findOrFail($id);

        // Verify ownership
        if ($dataset->restaurant_id != session('selected_restaurant_id')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (! $dataset->canBeProcessed()) {
            return response()->json([
                'error' => 'Dataset cannot be processed',
                'status' => $dataset->status,
                'message' => "Dataset status '{$dataset->status}' does not allow processing. Only 'uploaded' and 'failed' datasets can be processed.",
            ], 400);
        }

        // If dataset failed before, reset it for reprocessing
        if ($dataset->status === 'failed') {
            $dataset->resetForReprocessing();
        }

        // Update status to processing
        $dataset->update(['status' => 'processing']);

        // Dispatch job to queue
        ProcessDataset::dispatch($dataset);

        $message = $dataset->wasChanged() && $dataset->getOriginal('status') === 'failed' 
            ? 'Dataset reprocessing started'
            : 'Dataset processing started';

        return response()->json([
            'success' => true,
            'message' => $message,
            'dataset' => [
                'id' => $dataset->id,
                'status' => $dataset->status,
                'can_reprocess' => $dataset->canBeProcessed(),
            ],
        ]);
    }

    /**
     * Get dataset status for polling
     */
    public function status($id)
    {
        $dataset = Dataset::findOrFail($id);

        // Verify ownership
        if ($dataset->restaurant_id != session('selected_restaurant_id')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'id' => $dataset->id,
            'status' => $dataset->status,
            'total_records' => $dataset->total_records,
            'processed_at' => $dataset->processed_at,
            'validation_errors' => $dataset->validation_errors,
            'processing_notes' => $dataset->processing_notes,
            'can_reprocess' => $dataset->canBeProcessed(),
            'is_processing' => $dataset->isProcessing(),
            'is_completed' => $dataset->isCompleted(),
            'is_failed' => $dataset->isFailed(),
        ]);
    }

    /**
     * Show dataset details
     */
    public function show($id)
    {
        $dataset = Dataset::with('uploadedBy', 'restaurant')->findOrFail($id);

        // Verify ownership
        if ($dataset->restaurant_id != session('selected_restaurant_id')) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized');
        }

        // If AJAX request for status polling
        if (request()->wantsJson()) {
            return response()->json([
                'status' => $dataset->status,
                'total_records' => $dataset->total_records,
                'processed_at' => $dataset->processed_at,
            ]);
        }

        // Load a preview of the data
        $preview = $this->getDatasetPreview($dataset);

        return view('datasets.show', compact('dataset', 'preview'));
    }

    /**
     * Delete a dataset
     */
    public function destroy($id)
    {
        $dataset = Dataset::findOrFail($id);

        // Verify ownership
        if ($dataset->restaurant_id != session('selected_restaurant_id')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();
        
        try {
            // Count related data before deletion for reporting
            $deletedCounts = $this->deleteRelatedData($dataset);

            // Delete file
            if (Storage::exists($dataset->file_path)) {
                Storage::delete($dataset->file_path);
            }

            // Delete dataset record
            $dataset->delete();

            DB::commit();

            // Prepare success message with deletion details
            $message = 'Dataset deleted successfully';
            if (array_sum($deletedCounts) > 0) {
                $details = [];
                if ($deletedCounts['orders'] > 0) {
                    $details[] = "{$deletedCounts['orders']} orders";
                }
                if ($deletedCounts['menu_items'] > 0) {
                    $details[] = "{$deletedCounts['menu_items']} menu items";
                }
                if ($deletedCounts['inventory_items'] > 0) {
                    $details[] = "{$deletedCounts['inventory_items']} inventory items";
                }
                
                if (!empty($details)) {
                    $message .= '. Also deleted: ' . implode(', ', $details);
                }
            }

            Log::info("Dataset {$dataset->id} deleted with related data", $deletedCounts);

            return response()->json([
                'success' => true,
                'message' => $message,
                'deleted_counts' => $deletedCounts,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Failed to delete dataset {$dataset->id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete dataset',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete related data from other tables
     */
    private function deleteRelatedData(Dataset $dataset)
    {
        $deletedCounts = [
            'orders' => 0,
            'menu_items' => 0,
            'inventory_items' => 0,
        ];

        // Delete orders related to this dataset
        $ordersQuery = Order::where('dataset_id', $dataset->id);
        $deletedCounts['orders'] = $ordersQuery->count();
        if ($deletedCounts['orders'] > 0) {
            // Delete order items first (due to foreign key constraint)
            DB::table('order_items')
                ->whereIn('order_id', $ordersQuery->pluck('id'))
                ->delete();
            
            // Then delete orders
            $ordersQuery->delete();
        }

        // Delete menu items related to this dataset
        $menuItemsQuery = MenuItem::where('dataset_id', $dataset->id);
        $deletedCounts['menu_items'] = $menuItemsQuery->count();
        if ($deletedCounts['menu_items'] > 0) {
            $menuItemsQuery->delete();
        }

        // Delete inventory items related to this dataset
        $inventoryItemsQuery = InventoryItem::where('dataset_id', $dataset->id);
        $deletedCounts['inventory_items'] = $inventoryItemsQuery->count();
        if ($deletedCounts['inventory_items'] > 0) {
            $inventoryItemsQuery->delete();
        }

        return $deletedCounts;
    }

    /**
     * Download sample template
     */
    public function downloadTemplate($type)
    {
        // if (! in_array($type, ['sales', 'customers', 'menu', 'inventory'])) {
        //     abort(404);
        // }

        // $spreadsheet = $this->createTemplate($type);
        // $filename = "template_{$type}.xlsx";

        // // Create temp file
        // $tempFile = tempnam(sys_get_temp_dir(), 'template_');
        // $writer = new Xlsx($spreadsheet);
        // $writer->save($tempFile);

        // return response()->download($tempFile, $filename, [
        //     'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        // ])->deleteFileAfterSend(true);

        if (! in_array($type, ['sales', 'customers', 'menu', 'inventory'])) {
            abort(404);
        }

        // return pre-made templates from public/templates/template_{type}.xlsx
        $filePath = public_path("templates/template_{$type}.xlsx");
        if (! file_exists($filePath)) {
            abort(404);
        }

        $filename = "template_{$type}.xlsx";

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Validate dataset structure
     */
    private function validateDatasetStructure($file, $type)
    {
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $headers = $worksheet->rangeToArray('A1:Z1')[0];
            $headers = array_filter($headers); // Remove empty values

            $expectedHeaders = $this->getExpectedHeaders($type);

            // Check if all expected headers are present
            $missingHeaders = array_diff($expectedHeaders, $headers);

            if (! empty($missingHeaders)) {
                return [
                    'valid' => false,
                    'errors' => ['Missing columns: '.implode(', ', $missingHeaders)],
                ];
            }

            // Get total records (excluding header)
            $totalRecords = $worksheet->getHighestRow() - 1;

            // Auto-detect date range
            $dateRange = $this->detectDateRange($worksheet, $type);

            return [
                'valid' => true,
                'total_records' => $totalRecords,
                'start_date' => $dateRange['start'],
                'end_date' => $dateRange['end'],
            ];

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'errors' => ['Failed to read file: '.$e->getMessage()],
            ];
        }
    }

    /**
     * Get expected headers for each dataset type
     */
    private function getExpectedHeaders($type)
    {
        $headers = [
            'sales' => ['order_id', 'date', 'time', 'customer_name', 'menu_item', 'quantity', 'unit_price', 'total_amount', 'payment_method', 'status'],
            'customers' => ['customer_id', 'name', 'email', 'phone', 'registration_date', 'total_orders', 'total_spent', 'status'],
            'menu' => ['item_id', 'name', 'category', 'description', 'price', 'cost', 'status', 'allergens', 'prep_time'],
            'inventory' => ['item_name', 'category', 'unit', 'current_stock', 'minimum_stock', 'unit_cost', 'supplier', 'last_updated'],
        ];

        return $headers[$type] ?? [];
    }

    /**
     * Detect date range from dataset
     */
    private function detectDateRange($worksheet, $type)
    {
        $dateColumn = $type === 'customers' ? 'E' : ($type === 'inventory' ? 'H' : 'B'); // registration_date, last_updated, or date
        $highestRow = $worksheet->getHighestRow();

        $dates = [];
        for ($row = 2; $row <= min($highestRow, 1000); $row++) { // Check max 1000 rows
            $dateValue = $worksheet->getCell($dateColumn.$row)->getValue();
            if ($dateValue) {
                try {
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue);
                    $dates[] = $date;
                } catch (\Exception $e) {
                    // Try parsing as string
                    $parsedDate = date_create($dateValue);
                    if ($parsedDate) {
                        $dates[] = $parsedDate;
                    }
                }
            }
        }

        if (empty($dates)) {
            return ['start' => null, 'end' => null];
        }

        sort($dates);

        return [
            'start' => reset($dates)->format('Y-m-d'),
            'end' => end($dates)->format('Y-m-d'),
        ];
    }

    /**
     * Create template for dataset type
     */
    private function createTemplate($type)
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headers = $this->getExpectedHeaders($type);
        $examples = $this->getExampleData($type);

        // Set headers
        foreach ($headers as $index => $header) {
            $sheet->setCellValue(chr(65 + $index).'1', $header);
            $sheet->getStyle(chr(65 + $index).'1')->getFont()->setBold(true);
        }

        // Add example rows
        foreach ($examples as $rowIndex => $example) {
            foreach ($example as $colIndex => $value) {
                $sheet->setCellValue(chr(65 + $colIndex).($rowIndex + 2), $value);
            }
        }

        // Auto-size columns
        foreach (range('A', chr(65 + count($headers) - 1)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    /**
     * Get example data for templates
     */
    private function getExampleData($type)
    {
        $examples = [
            'sales' => [
                ['ORD001', '2024-01-15', '12:30:00', 'John Doe', 'Nasi Goreng', 2, 25000, 50000, 'cash', 'completed'],
                ['ORD002', '2024-01-15', '13:45:00', 'Jane Smith', 'Mie Goreng', 1, 22000, 22000, 'card', 'completed'],
            ],
            'customers' => [
                ['CUST001', 'John Doe', 'john@example.com', '081234567890', '2024-01-01', 15, 500000, 'active'],
                ['CUST002', 'Jane Smith', 'jane@example.com', '081234567891', '2024-01-05', 8, 300000, 'active'],
            ],
            'menu' => [
                ['MENU001', 'Nasi Goreng', 'Main Course', 'Fried rice with vegetables', 25000, 15000, 'active', 'None', 15],
                ['MENU002', 'Mie Goreng', 'Main Course', 'Fried noodles', 22000, 12000, 'active', 'Gluten', 12],
            ],
            'inventory' => [
                ['Rice', 'Raw Materials', 'kg', 50, 20, 8000, 'Supplier A', '2024-01-15'],
                ['Cooking Oil', 'Raw Materials', 'liter', 30, 10, 15000, 'Supplier B', '2024-01-15'],
            ],
        ];

        return $examples[$type] ?? [];
    }

    /**
     * Get preview of dataset content
     */
    private function getDatasetPreview($dataset)
    {
        try {
            $filePath = storage_path('app/'.$dataset->file_path);

            if (! file_exists($filePath)) {
                return ['error' => 'File not found'];
            }

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get first 10 rows as preview
            $preview = $worksheet->rangeToArray('A1:Z11');

            return [
                'headers' => array_filter($preview[0]),
                'rows' => array_slice($preview, 1, 10),
            ];

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
