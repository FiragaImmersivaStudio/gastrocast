<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Restaurants that this user owns
     */
    public function ownedRestaurants()
    {
        return $this->hasMany(Restaurant::class, 'owner_user_id');
    }

    /**
     * Restaurants that this user has access to (including owned)
     */
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * What-if scenarios created by this user
     */
    public function whatifScenarios()
    {
        return $this->hasMany(WhatifScenario::class, 'created_by');
    }

    /**
     * Check if user has access to a specific restaurant
     */
    public function hasAccessToRestaurant($restaurantId)
    {
        return $this->restaurants()->where('restaurant_id', $restaurantId)->exists();
    }

    /**
     * Get user's role for a specific restaurant
     */
    public function getRoleForRestaurant($restaurantId)
    {
        $pivot = $this->restaurants()->where('restaurant_id', $restaurantId)->first()?->pivot;
        return $pivot?->role;
    }
}
