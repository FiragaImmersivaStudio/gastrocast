<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'timezone',
        'default_restaurant_id',
        'notification_forecast_ready',
        'notification_system_updates',
        'notification_forecast_next_month',
        'two_factor_secret',
        'two_factor_enabled',
        'deletion_requested_at',
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
        'notification_forecast_ready' => 'boolean',
        'notification_system_updates' => 'boolean',
        'notification_forecast_next_month' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'deleted_at' => 'datetime',
        'deletion_requested_at' => 'datetime',
    ];

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

    /**
     * User's invoices
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * User's default restaurant
     */
    public function defaultRestaurant()
    {
        return $this->belongsTo(Restaurant::class, 'default_restaurant_id');
    }
}
