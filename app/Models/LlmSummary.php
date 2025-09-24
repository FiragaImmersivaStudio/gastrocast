<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LlmSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'context',
        'prompt',
        'response',
        'action_items',
        'model_used',
        'tokens_used',
        'processing_time_ms',
    ];

    protected $casts = [
        'action_items' => 'array',
        'tokens_used' => 'integer',
        'processing_time_ms' => 'decimal:2',
    ];

    /**
     * Get the restaurant that owns the summary
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the latest summary for a specific context
     */
    public static function getLatestForContext($restaurantId, $context)
    {
        return static::where('restaurant_id', $restaurantId)
            ->where('context', $context)
            ->latest()
            ->first();
    }
}
