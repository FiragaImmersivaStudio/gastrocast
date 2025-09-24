<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SampleDataController extends Controller
{
    /**
     * Download sample data file
     */
    public function download(Request $request, $type)
    {
        $fileMap = [
            'sales' => 'sample-sales-data.csv',
            'menu' => 'sample-menu-items.csv',
            'inventory' => 'sample-inventory.csv',
            'staff' => 'sample-staff-data.csv',
        ];

        if (!array_key_exists($type, $fileMap)) {
            abort(404, 'Sample data type not found');
        }

        $filename = $fileMap[$type];
        $path = "sample-data/{$filename}";

        if (!Storage::exists($path)) {
            abort(404, 'Sample file not found');
        }

        return Storage::download($path, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get sample data information
     */
    public function info()
    {
        $samples = [
            'sales' => [
                'name' => 'Sales Transaction Data',
                'description' => 'Sample sales data including order details, customer info, and payment information',
                'columns' => ['order_id', 'date', 'time', 'customer_name', 'menu_item', 'quantity', 'unit_price', 'total_amount', 'payment_method', 'status'],
                'filename' => 'sample-sales-data.csv'
            ],
            'menu' => [
                'name' => 'Menu Items Data',
                'description' => 'Sample menu items with pricing, categories, and preparation details',
                'columns' => ['item_id', 'name', 'category', 'description', 'price', 'cost', 'status', 'allergens', 'prep_time'],
                'filename' => 'sample-menu-items.csv'
            ],
            'inventory' => [
                'name' => 'Inventory Data',
                'description' => 'Sample inventory data with stock levels, suppliers, and costs',
                'columns' => ['item_name', 'category', 'unit', 'current_stock', 'minimum_stock', 'unit_cost', 'supplier', 'last_updated'],
                'filename' => 'sample-inventory.csv'
            ],
            'staff' => [
                'name' => 'Staff Data',
                'description' => 'Sample employee data with positions, rates, and contact information',
                'columns' => ['employee_id', 'full_name', 'position', 'department', 'hourly_rate', 'hire_date', 'phone', 'email', 'status'],
                'filename' => 'sample-staff-data.csv'
            ]
        ];

        return response()->json([
            'data' => $samples,
            'message' => 'Sample data information retrieved successfully'
        ]);
    }
}
