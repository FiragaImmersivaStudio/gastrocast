<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Restaurant extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'owner_user_id',
        'name',
        'category',
        'address',
        'phone',
        'email',
        'timezone',
        'operating_hours',
        'is_active',
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'category', 'address', 'phone', 'email', 'timezone', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Boot method to apply global scopes
     */
    protected static function boot()
    {
        parent::boot();

        // Apply tenant scope if active restaurant is set
        static::addGlobalScope('tenant', function ($builder) {
            $activeRestaurantId = config('app.active_restaurant_id');
            if ($activeRestaurantId) {
                $builder->where('id', $activeRestaurantId);
            }
        });
    }

    /**
     * Owner of this restaurant
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * Users who have access to this restaurant
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'restaurant_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Menu categories
     */
    public function menuCategories()
    {
        return $this->hasMany(MenuCategory::class);
    }

    /**
     * Menu items
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Inventory items
     */
    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    /**
     * Stock movements
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Staff members
     */
    public function staffMembers()
    {
        return $this->hasMany(StaffMember::class);
    }

    /**
     * Shifts
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    /**
     * Kitchen stations
     */
    public function kitchenStations()
    {
        return $this->hasMany(KitchenStation::class);
    }

    /**
     * Promotions
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * Forecasts
     */
    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }

    /**
     * What-if scenarios
     */
    public function whatifScenarios()
    {
        return $this->hasMany(WhatifScenario::class);
    }

    /**
     * LLM summaries
     */
    public function llmSummaries()
    {
        return $this->hasMany(LlmSummary::class);
    }

    /**
     * Hourly metrics
     */
    public function metricsHourly()
    {
        return $this->hasMany(MetricsHourly::class);
    }

    /**
     * Daily metrics
     */
    public function metricsDaily()
    {
        return $this->hasMany(MetricsDaily::class);
    }
}
