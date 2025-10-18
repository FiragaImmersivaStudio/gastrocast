<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Forecast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ForecastService
{
    protected $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * Generate comprehensive forecast for a restaurant
     */
    public function generateForecast(int $restaurantId, string $startDate, string $endDate, array $metrics = []): array
    {
        $startTime = microtime(true);
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Validate date range (max 90 days)
        $daysDiff = $start->diffInDays($end);
        if ($daysDiff > 90) {
            return [
                'success' => false,
                'error' => 'Forecast period cannot exceed 90 days'
            ];
        }

        // Validate dates are in the future
        $now = Carbon::now();
        if ($start->lessThan($now->startOfDay())) {
            return [
                'success' => false,
                'error' => 'Start date must be in the future'
            ];
        }

        // Get historical data
        $historicalData = $this->getHistoricalData($restaurantId);
        
        if (empty($historicalData)) {
            return [
                'success' => false,
                'error' => 'Insufficient historical data for forecasting'
            ];
        }

        // Perform statistical forecasting
        $salesForecast = $this->forecastSales($historicalData, $daysDiff);
        $profitForecast = $this->forecastProfit($historicalData, $daysDiff);
        $visitorForecast = $this->forecastVisitors($historicalData, $daysDiff);
        $peakHours = $this->analyzePeakHours($historicalData);

        // Calculate accuracy metrics based on recent forecasts
        $accuracy = $this->calculateAccuracy($restaurantId);

        // Prepare data for AI summary
        $forecastData = [
            'sales' => $salesForecast,
            'profit' => $profitForecast,
            'visitors' => $visitorForecast,
            'peak_hours' => $peakHours,
            'accuracy' => $accuracy,
            'period' => [
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'days' => $daysDiff
            ]
        ];

        // Generate AI summary using Groq
        $aiSummary = $this->generateAISummary($forecastData, $historicalData);

        // Build result array
        $result = [
            'daily_predictions' => $this->buildDailyPredictions($start, $daysDiff, $salesForecast, $visitorForecast, $profitForecast),
            'peak_hours_heatmap' => $this->buildPeakHoursHeatmap($peakHours),
            'summary_metrics' => [
                'total_predicted_sales' => array_sum($salesForecast['predictions']),
                'total_predicted_profit' => array_sum($profitForecast['predictions']),
                'total_predicted_visitors' => array_sum($visitorForecast['predictions']),
                'avg_daily_sales' => round(array_sum($salesForecast['predictions']) / count($salesForecast['predictions']), 2),
                'avg_daily_visitors' => round(array_sum($visitorForecast['predictions']) / count($visitorForecast['predictions']), 0),
                'accuracy' => $accuracy,
            ],
            'ai_summary' => $aiSummary,
            'processing_time_ms' => round((microtime(true) - $startTime) * 1000, 2),
        ];

        // Save forecast to database
        $this->saveForecast($restaurantId, $start, $end, $daysDiff, $result, $aiSummary);

        return [
            'success' => true,
            'data' => $result
        ];
    }

    /**
     * Get historical order data for forecasting
     */
    protected function getHistoricalData(int $restaurantId): array
    {
        // Get last 90 days of data
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(90);

        $orders = Order::where('restaurant_id', $restaurantId)
            ->whereBetween('order_dt', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE(order_dt) as date'),
                DB::raw('HOUR(order_dt) as hour'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(net_amount) as total_sales'),
                DB::raw('SUM(party_size) as total_visitors'),
                DB::raw('AVG(net_amount) as avg_order_value')
            )
            ->groupBy(DB::raw('DATE(order_dt)'), DB::raw('HOUR(order_dt)'))
            ->orderBy('date')
            ->orderBy('hour')
            ->get()
            ->toArray();

        return $orders;
    }

    /**
     * Forecast sales using exponential smoothing
     */
    protected function forecastSales(array $historicalData, int $days): array
    {
        // Aggregate by day
        $dailySales = [];
        foreach ($historicalData as $record) {
            $date = $record['date'];
            if (!isset($dailySales[$date])) {
                $dailySales[$date] = 0;
            }
            $dailySales[$date] += floatval($record['total_sales']);
        }

        $values = array_values($dailySales);
        
        if (empty($values)) {
            return ['predictions' => array_fill(0, $days, 0), 'confidence' => 0];
        }

        // Simple exponential smoothing
        $alpha = 0.3;
        $predictions = [];
        $lastValue = end($values);
        $trend = $this->calculateTrend($values);

        for ($i = 0; $i < $days; $i++) {
            $prediction = $lastValue * (1 + ($trend * ($i + 1)));
            $predictions[] = max(0, round($prediction, 2));
        }

        return [
            'predictions' => $predictions,
            'confidence' => $this->calculateConfidence($values),
            'historical_avg' => round(array_sum($values) / count($values), 2),
            'trend' => $trend
        ];
    }

    /**
     * Forecast profit (estimated as 20-25% of sales)
     */
    protected function forecastProfit(array $historicalData, int $days): array
    {
        $salesForecast = $this->forecastSales($historicalData, $days);
        $profitMargin = 0.22; // 22% average profit margin

        $predictions = array_map(function($sales) use ($profitMargin) {
            return round($sales * $profitMargin, 2);
        }, $salesForecast['predictions']);

        return [
            'predictions' => $predictions,
            'confidence' => $salesForecast['confidence'],
            'profit_margin' => $profitMargin
        ];
    }

    /**
     * Forecast visitor count
     */
    protected function forecastVisitors(array $historicalData, int $days): array
    {
        // Aggregate by day
        $dailyVisitors = [];
        foreach ($historicalData as $record) {
            $date = $record['date'];
            if (!isset($dailyVisitors[$date])) {
                $dailyVisitors[$date] = 0;
            }
            $dailyVisitors[$date] += intval($record['total_visitors']);
        }

        $values = array_values($dailyVisitors);
        
        if (empty($values)) {
            return ['predictions' => array_fill(0, $days, 0), 'confidence' => 0];
        }

        $alpha = 0.3;
        $predictions = [];
        $lastValue = end($values);
        $trend = $this->calculateTrend($values);

        for ($i = 0; $i < $days; $i++) {
            $prediction = $lastValue * (1 + ($trend * ($i + 1)));
            $predictions[] = max(0, round($prediction, 0));
        }

        return [
            'predictions' => $predictions,
            'confidence' => $this->calculateConfidence($values),
            'historical_avg' => round(array_sum($values) / count($values), 0),
            'trend' => $trend
        ];
    }

    /**
     * Analyze peak hours from historical data
     */
    protected function analyzePeakHours(array $historicalData): array
    {
        $hourlyData = [];
        
        foreach ($historicalData as $record) {
            $hour = intval($record['hour']);
            if (!isset($hourlyData[$hour])) {
                $hourlyData[$hour] = [
                    'total_orders' => 0,
                    'total_visitors' => 0,
                    'count' => 0
                ];
            }
            $hourlyData[$hour]['total_orders'] += intval($record['order_count']);
            $hourlyData[$hour]['total_visitors'] += intval($record['total_visitors']);
            $hourlyData[$hour]['count']++;
        }

        // Calculate averages
        $peakHours = [];
        foreach ($hourlyData as $hour => $data) {
            if ($data['count'] > 0) {
                $peakHours[] = [
                    'hour' => $hour,
                    'avg_orders' => round($data['total_orders'] / $data['count'], 1),
                    'avg_visitors' => round($data['total_visitors'] / $data['count'], 0),
                    'intensity' => $this->calculateIntensity($data['total_visitors'] / $data['count'])
                ];
            }
        }

        // Sort by average visitors descending
        usort($peakHours, function($a, $b) {
            return $b['avg_visitors'] <=> $a['avg_visitors'];
        });

        return $peakHours;
    }

    /**
     * Calculate trend from historical values
     */
    protected function calculateTrend(array $values): float
    {
        $n = count($values);
        if ($n < 2) return 0;

        // Simple linear regression slope
        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumX += $i;
            $sumY += $values[$i];
            $sumXY += $i * $values[$i];
            $sumX2 += $i * $i;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $avgValue = $sumY / $n;

        return $avgValue > 0 ? ($slope / $avgValue) : 0;
    }

    /**
     * Calculate confidence level based on data variance
     */
    protected function calculateConfidence(array $values): float
    {
        if (count($values) < 2) return 0.5;

        $mean = array_sum($values) / count($values);
        $variance = 0;

        foreach ($values as $value) {
            $variance += pow($value - $mean, 2);
        }

        $variance /= count($values);
        $stdDev = sqrt($variance);
        $cv = $mean > 0 ? ($stdDev / $mean) : 1;

        // Lower coefficient of variation = higher confidence
        // Convert to 0-100 scale
        $confidence = max(50, min(95, 95 - ($cv * 20)));

        return round($confidence, 1);
    }

    /**
     * Calculate intensity level for heatmap
     */
    protected function calculateIntensity(float $avgVisitors): int
    {
        if ($avgVisitors >= 50) return 3; // High
        if ($avgVisitors >= 30) return 2; // Medium
        if ($avgVisitors >= 15) return 1; // Low
        return 0; // Very Low
    }

    /**
     * Calculate forecast accuracy based on previous forecasts
     */
    protected function calculateAccuracy(int $restaurantId): float
    {
        // Get recent forecasts with MAPE scores
        $recentForecasts = Forecast::where('restaurant_id', $restaurantId)
            ->whereNotNull('mape')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($recentForecasts->isEmpty()) {
            return 85.0; // Default accuracy
        }

        $avgMape = $recentForecasts->avg('mape');
        
        // Convert MAPE to accuracy percentage
        $accuracy = max(50, min(99, 100 - $avgMape));

        return round($accuracy, 1);
    }

    /**
     * Build daily predictions array
     */
    protected function buildDailyPredictions($startDate, int $days, array $salesForecast, array $visitorForecast, array $profitForecast): array
    {
        $predictions = [];
        $date = clone $startDate;

        for ($i = 0; $i < $days; $i++) {
            $predictions[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->format('l'),
                'predicted_sales' => $salesForecast['predictions'][$i] ?? 0,
                'predicted_profit' => $profitForecast['predictions'][$i] ?? 0,
                'predicted_visitors' => $visitorForecast['predictions'][$i] ?? 0,
                'confidence' => round(($salesForecast['confidence'] + $visitorForecast['confidence']) / 2, 1)
            ];
            $date->addDay();
        }

        return $predictions;
    }

    /**
     * Build peak hours heatmap data
     */
    protected function buildPeakHoursHeatmap(array $peakHours): array
    {
        // Create a 7-day x 18-hour grid (6 AM to 11 PM)
        $heatmap = [];
        
        for ($hour = 6; $hour <= 23; $hour++) {
            $hourData = [
                'hour' => $hour,
                'hour_label' => sprintf('%02d:00', $hour),
                'days' => []
            ];

            // Find data for this hour
            $hourInfo = collect($peakHours)->firstWhere('hour', $hour);
            
            for ($day = 0; $day < 7; $day++) {
                $intensity = $hourInfo ? $hourInfo['intensity'] : 0;
                $avgVisitors = $hourInfo ? $hourInfo['avg_visitors'] : 0;
                
                $hourData['days'][] = [
                    'day' => $day,
                    'intensity' => $intensity,
                    'avg_visitors' => $avgVisitors
                ];
            }

            $heatmap[] = $hourData;
        }

        return $heatmap;
    }

    /**
     * Generate AI summary using Groq
     */
    protected function generateAISummary(array $forecastData, array $historicalData): array
    {
        $prompt = $this->buildForecastPrompt($forecastData, $historicalData);
        
        $result = $this->groqService->generateSummary($prompt, 'llama-3.1-70b-versatile');

        if (!$result['success']) {
            return [
                'text' => 'Forecast generated successfully with statistical methods.',
                'model_used' => 'statistical',
                'tokens_used' => 0
            ];
        }

        return [
            'text' => $result['response'],
            'action_items' => $result['action_items'] ?? [],
            'model_used' => $result['model_used'],
            'tokens_used' => $result['tokens_used']
        ];
    }

    /**
     * Build prompt for AI forecast summary
     */
    protected function buildForecastPrompt(array $forecastData, array $historicalData): string
    {
        $period = $forecastData['period'];
        $totalSales = $forecastData['sales']['predictions'] ? array_sum($forecastData['sales']['predictions']) : 0;
        $totalProfit = $forecastData['profit']['predictions'] ? array_sum($forecastData['profit']['predictions']) : 0;
        $totalVisitors = $forecastData['visitors']['predictions'] ? array_sum($forecastData['visitors']['predictions']) : 0;
        $avgDailySales = $period['days'] > 0 ? round($totalSales / $period['days'], 2) : 0;
        $avgDailyVisitors = $period['days'] > 0 ? round($totalVisitors / $period['days'], 0) : 0;
        
        $historicalAvgSales = $forecastData['sales']['historical_avg'] ?? 0;
        $salesTrend = $forecastData['sales']['trend'] ?? 0;
        $trendDirection = $salesTrend > 0.01 ? 'meningkat' : ($salesTrend < -0.01 ? 'menurun' : 'stabil');
        $trendPercent = abs($salesTrend * 100);

        // Get top 3 peak hours
        $topPeakHours = array_slice($forecastData['peak_hours'], 0, 3);
        $peakHoursText = implode(', ', array_map(function($h) {
            return sprintf('%02d:00 (%d pengunjung)', $h['hour'], $h['avg_visitors']);
        }, $topPeakHours));

        return "Analisa hasil forecast restoran untuk periode {$period['start']} sampai {$period['end']} ({$period['days']} hari):

DATA FORECAST:
- Total Prediksi Penjualan: Rp " . number_format($totalSales, 0, ',', '.') . "
- Total Prediksi Keuntungan: Rp " . number_format($totalProfit, 0, ',', '.') . "
- Total Prediksi Pengunjung: " . number_format($totalVisitors, 0, ',', '.') . " orang
- Rata-rata Penjualan Harian: Rp " . number_format($avgDailySales, 0, ',', '.') . "
- Rata-rata Pengunjung Harian: {$avgDailyVisitors} orang
- Trend Penjualan: {$trendDirection} (" . number_format($trendPercent, 1) . "%)
- Jam Sibuk (Peak Hours): {$peakHoursText}
- Akurasi Model: {$forecastData['accuracy']}%

DATA HISTORIS:
- Rata-rata Penjualan Historis: Rp " . number_format($historicalAvgSales, 0, ',', '.') . "
- Confidence Level: {$forecastData['sales']['confidence']}%

Berikan analisa mendalam dalam format narasi yang mudah dipahami pemilik restoran dengan struktur:
1. Executive Summary (2-3 kalimat ringkasan)
2. Analisa Trend dan Performa
3. Prediksi Kunci (penjualan, pengunjung, keuntungan)
4. Rekomendasi Strategis (3-4 action items spesifik)
5. Peak Hours dan Kapasitas

Gunakan bahasa Indonesia yang natural, profesional, dan mudah dipahami. Berikan insight yang actionable untuk meningkatkan performa restoran.";
    }

    /**
     * Save forecast to database
     */
    protected function saveForecast(int $restaurantId, $startDate, $endDate, int $days, array $result, array $aiSummary): void
    {
        try {
            Forecast::create([
                'restaurant_id' => $restaurantId,
                'horizon_days' => $days,
                'granularity' => 'day',
                'forecast_date' => Carbon::now(),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'params_json' => [
                    'method' => 'hybrid',
                    'statistical' => 'exponential_smoothing',
                    'ai_model' => $aiSummary['model_used'] ?? 'none'
                ],
                'result_json' => $result['daily_predictions'],
                'ci_lower_json' => [],
                'ci_upper_json' => [],
                'mape' => null, // Will be calculated after actual data is available
                'summary_text' => $aiSummary['text'] ?? null,
                'model_used' => $aiSummary['model_used'] ?? 'statistical',
                'tokens_used' => $aiSummary['tokens_used'] ?? 0,
                'processing_time_ms' => $result['processing_time_ms']
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save forecast', [
                'error' => $e->getMessage(),
                'restaurant_id' => $restaurantId
            ]);
        }
    }
}
