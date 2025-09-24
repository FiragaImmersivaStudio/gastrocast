<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetricsApiController extends Controller
{
    /**
     * Get metrics overview
     */
    public function overview(Request $request)
    {
        $restaurantId = $request->query('restaurant_id');
        $period = $request->query('period', '30d'); // 7d, 30d, 90d, 1y

        $overview = [
            'restaurant_id' => $restaurantId,
            'period' => $period,
            'total_sales' => 45600,
            'total_orders' => 1250,
            'total_customers' => 980,
            'avg_order_value' => 36.48,
            'growth_metrics' => [
                'sales_growth' => 12.5,
                'order_growth' => 8.3,
                'customer_growth' => 15.2
            ],
            'top_performing_items' => [
                ['name' => 'Margherita Pizza', 'quantity_sold' => 180, 'revenue' => 2700],
                ['name' => 'Caesar Salad', 'quantity_sold' => 145, 'revenue' => 1885],
                ['name' => 'Grilled Salmon', 'quantity_sold' => 98, 'revenue' => 2450]
            ],
            'customer_satisfaction' => [
                'avg_rating' => 4.2,
                'total_reviews' => 156,
                'satisfaction_rate' => 87.5
            ]
        ];

        return response()->json([
            'data' => $overview,
            'message' => 'Metrics overview retrieved successfully'
        ]);
    }

    /**
     * Get trends data
     */
    public function trends(Request $request)
    {
        $restaurantId = $request->query('restaurant_id');
        $metric = $request->query('metric', 'sales'); // sales, orders, customers
        $period = $request->query('period', '30d');

        $trends = [
            'metric' => $metric,
            'period' => $period,
            'data_points' => [
                ['date' => '2024-01-01', 'value' => 1250],
                ['date' => '2024-01-02', 'value' => 1380],
                ['date' => '2024-01-03', 'value' => 1420],
                ['date' => '2024-01-04', 'value' => 1180],
                ['date' => '2024-01-05', 'value' => 1650],
                ['date' => '2024-01-06', 'value' => 1780],
                ['date' => '2024-01-07', 'value' => 1890]
            ],
            'trend_analysis' => [
                'direction' => 'increasing',
                'growth_rate' => 8.5,
                'volatility' => 'low',
                'seasonality_detected' => true
            ],
            'predictions' => [
                ['date' => '2024-01-08', 'predicted_value' => 1920, 'confidence' => 0.82],
                ['date' => '2024-01-09', 'predicted_value' => 1850, 'confidence' => 0.78],
                ['date' => '2024-01-10', 'predicted_value' => 2100, 'confidence' => 0.85]
            ]
        ];

        return response()->json([
            'data' => $trends,
            'message' => 'Trends data retrieved successfully'
        ]);
    }

    /**
     * Get heatmap data
     */
    public function heatmap(Request $request)
    {
        $restaurantId = $request->query('restaurant_id');
        $type = $request->query('type', 'hourly_sales'); // hourly_sales, daily_customers, table_turnover

        $heatmapData = [
            'type' => $type,
            'data' => [
                // Hour vs Day of Week heatmap
                ['hour' => 6, 'day' => 'Monday', 'value' => 12],
                ['hour' => 7, 'day' => 'Monday', 'value' => 25],
                ['hour' => 8, 'day' => 'Monday', 'value' => 45],
                ['hour' => 12, 'day' => 'Monday', 'value' => 180],
                ['hour' => 13, 'day' => 'Monday', 'value' => 165],
                ['hour' => 18, 'day' => 'Monday', 'value' => 220],
                ['hour' => 19, 'day' => 'Monday', 'value' => 195],
                ['hour' => 20, 'day' => 'Monday', 'value' => 175],
                // ... more data points for other days
                ['hour' => 12, 'day' => 'Saturday', 'value' => 280],
                ['hour' => 13, 'day' => 'Saturday', 'value' => 295],
                ['hour' => 18, 'day' => 'Saturday', 'value' => 350],
                ['hour' => 19, 'day' => 'Saturday', 'value' => 385],
                ['hour' => 20, 'day' => 'Saturday', 'value' => 320]
            ],
            'max_value' => 385,
            'min_value' => 12,
            'peak_times' => [
                ['day' => 'Saturday', 'hour' => 19, 'value' => 385],
                ['day' => 'Friday', 'hour' => 20, 'value' => 342],
                ['day' => 'Sunday', 'hour' => 13, 'value' => 298]
            ],
            'insights' => [
                'busiest_day' => 'Saturday',
                'busiest_hour' => 19,
                'quietest_day' => 'Tuesday',
                'quietest_hour' => 6
            ]
        ];

        return response()->json([
            'data' => $heatmapData,
            'message' => 'Heatmap data retrieved successfully'
        ]);
    }
}