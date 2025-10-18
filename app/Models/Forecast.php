<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'horizon_days',
        'granularity',
        'params_json',
        'result_json',
        'ci_lower_json',
        'ci_upper_json',
        'mape',
        'forecast_date',
        'start_date',
        'end_date',
        'summary_text',
        'model_used',
        'tokens_used',
        'processing_time_ms',
    ];

    protected $casts = [
        'params_json' => 'array',
        'result_json' => 'array',
        'ci_lower_json' => 'array',
        'ci_upper_json' => 'array',
        'mape' => 'decimal:2',
        'forecast_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'tokens_used' => 'integer',
        'processing_time_ms' => 'integer',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the latest forecast for a restaurant
     */
    public static function getLatestForRestaurant(int $restaurantId)
    {
        return static::where('restaurant_id', $restaurantId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get forecasts for a restaurant within a date range
     */
    public static function getForDateRange(int $restaurantId, $startDate, $endDate)
    {
        return static::where('restaurant_id', $restaurantId)
            ->whereBetween('forecast_date', [$startDate, $endDate])
            ->orderBy('forecast_date', 'asc')
            ->get();
    }
}
