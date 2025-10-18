<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forecast;
use App\Services\ForecastService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForecastApiController extends Controller
{
    protected $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    /**
     * Run a forecast analysis
     */
    public function run(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'metrics' => 'array',
            'metrics.*' => 'string|in:sales,profit,customer_count,peak_hours'
        ]);

        // Get restaurant ID from request or session
        $restaurantId = $request->restaurant_id ?: session('selected_restaurant_id');
        
        if (!$restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'No restaurant selected'
            ], 400);
        }

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Validate date range (max 90 days)
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $daysDiff = $start->diffInDays($end);

        if ($daysDiff > 90) {
            return response()->json([
                'success' => false,
                'message' => 'Periode forecast tidak boleh lebih dari 90 hari'
            ], 400);
        }

        // Validate start date is not in the past
        $now = Carbon::now();
        if ($start->lessThan($now->startOfDay())) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal mulai harus di masa depan'
            ], 400);
        }

        try {
            // Generate forecast
            $result = $this->forecastService->generateForecast(
                $restaurantId,
                $startDate,
                $endDate,
                $request->metrics ?? []
            );

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['error']
                ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $result['data'],
                'message' => 'Forecast berhasil dibuat'
            ]);
        } catch (\Exception $e) {
            Log::error('Forecast generation failed', [
                'error' => $e->getMessage(),
                'restaurant_id' => $restaurantId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat forecast: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get forecast summary
     */
    public function summary(Request $request)
    {
        $restaurantId = $request->query('restaurant_id') ?: session('selected_restaurant_id');
        
        if (!$restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'No restaurant selected'
            ], 400);
        }

        $totalForecasts = Forecast::where('restaurant_id', $restaurantId)->count();
        $latestForecast = Forecast::where('restaurant_id', $restaurantId)
            ->orderBy('created_at', 'desc')
            ->first();

        $avgAccuracy = Forecast::where('restaurant_id', $restaurantId)
            ->whereNotNull('mape')
            ->avg('mape');
        
        $accuracyRate = $avgAccuracy ? max(50, min(99, 100 - $avgAccuracy)) : 85.0;

        $summary = [
            'total_forecasts' => $totalForecasts,
            'accuracy_rate' => round($accuracyRate, 1),
            'last_forecast' => $latestForecast ? [
                'id' => $latestForecast->id,
                'created_at' => $latestForecast->created_at,
                'period' => [
                    'start' => $latestForecast->start_date?->format('Y-m-d'),
                    'end' => $latestForecast->end_date?->format('Y-m-d')
                ],
                'summary' => $latestForecast->summary_text
            ] : null
        ];

        return response()->json([
            'success' => true,
            'data' => $summary,
            'message' => 'Forecast summary retrieved successfully'
        ]);
    }

    /**
     * Show a specific forecast
     */
    public function show($forecastId)
    {
        $forecast = Forecast::with('restaurant')->find($forecastId);

        if (!$forecast) {
            return response()->json([
                'success' => false,
                'message' => 'Forecast not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $forecast->id,
                'restaurant_id' => $forecast->restaurant_id,
                'restaurant_name' => $forecast->restaurant->name ?? 'N/A',
                'period' => [
                    'start_date' => $forecast->start_date?->format('Y-m-d'),
                    'end_date' => $forecast->end_date?->format('Y-m-d'),
                    'days' => $forecast->horizon_days
                ],
                'predictions' => $forecast->result_json,
                'summary' => $forecast->summary_text,
                'accuracy' => $forecast->mape ? round(100 - $forecast->mape, 1) : null,
                'model_used' => $forecast->model_used,
                'created_at' => $forecast->created_at,
                'processing_time_ms' => $forecast->processing_time_ms
            ],
            'message' => 'Forecast retrieved successfully'
        ]);
    }

    /**
     * List recent forecasts
     */
    public function index(Request $request)
    {
        $restaurantId = $request->query('restaurant_id') ?: session('selected_restaurant_id');
        
        if (!$restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'No restaurant selected'
            ], 400);
        }

        $forecasts = Forecast::where('restaurant_id', $restaurantId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($forecast) {
                return [
                    'id' => $forecast->id,
                    'created_at' => $forecast->created_at->format('Y-m-d H:i'),
                    'period' => [
                        'start' => $forecast->start_date?->format('M d, Y'),
                        'end' => $forecast->end_date?->format('M d, Y')
                    ],
                    'horizon_days' => $forecast->horizon_days,
                    'accuracy' => $forecast->mape ? round(100 - $forecast->mape, 1) : null,
                    'model_used' => $forecast->model_used
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $forecasts,
            'message' => 'Forecasts retrieved successfully'
        ]);
    }
}