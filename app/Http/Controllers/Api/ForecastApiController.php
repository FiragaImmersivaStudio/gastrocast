<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForecastApiController extends Controller
{
    /**
     * Run a forecast analysis
     */
    public function run(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'metrics' => 'array',
            'metrics.*' => 'string|in:sales,customer_count,avg_order_value,peak_hours'
        ]);

        // Simulate forecast processing
        $forecastData = [
            'forecast_id' => uniqid('forecast_'),
            'restaurant_id' => $request->restaurant_id,
            'period' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ],
            'predictions' => [
                'daily_sales' => [
                    ['date' => '2024-01-01', 'predicted_sales' => 2500, 'confidence' => 0.85],
                    ['date' => '2024-01-02', 'predicted_sales' => 2800, 'confidence' => 0.82],
                    ['date' => '2024-01-03', 'predicted_sales' => 3200, 'confidence' => 0.88]
                ],
                'peak_hours' => [
                    ['hour' => 12, 'expected_customers' => 45],
                    ['hour' => 13, 'expected_customers' => 52],
                    ['hour' => 19, 'expected_customers' => 48],
                    ['hour' => 20, 'expected_customers' => 41]
                ]
            ],
            'status' => 'completed',
            'created_at' => now()
        ];

        return response()->json([
            'data' => $forecastData,
            'message' => 'Forecast analysis completed successfully'
        ]);
    }

    /**
     * Get forecast summary
     */
    public function summary(Request $request)
    {
        $restaurantId = $request->query('restaurant_id');
        
        $summary = [
            'total_forecasts' => 12,
            'active_forecasts' => 3,
            'accuracy_rate' => 87.5,
            'last_forecast' => [
                'id' => 'forecast_123',
                'created_at' => now()->subHours(2),
                'accuracy' => 89.2
            ],
            'trending_metrics' => [
                'sales_trend' => 'increasing',
                'customer_trend' => 'stable',
                'avg_order_value_trend' => 'increasing'
            ]
        ];

        return response()->json([
            'data' => $summary,
            'message' => 'Forecast summary retrieved successfully'
        ]);
    }

    /**
     * Show a specific forecast
     */
    public function show($forecastId)
    {
        // Simulate fetching a specific forecast
        $forecast = [
            'id' => $forecastId,
            'restaurant_id' => 1,
            'status' => 'completed',
            'created_at' => now()->subHours(1),
            'updated_at' => now()->subMinutes(30),
            'predictions' => [
                'weekly_sales' => 18500,
                'weekly_customers' => 450,
                'avg_order_value' => 41.11,
                'busiest_day' => 'Saturday',
                'slowest_day' => 'Tuesday'
            ],
            'confidence_metrics' => [
                'overall_confidence' => 86.5,
                'sales_confidence' => 88.2,
                'customer_confidence' => 84.8
            ]
        ];

        return response()->json([
            'data' => $forecast,
            'message' => 'Forecast retrieved successfully'
        ]);
    }
}