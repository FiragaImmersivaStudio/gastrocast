<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_user_id',
        'name',
        'category',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'description',
        'is_inside_mall',
        'mall_name',
        'timezone',
        'currency',
        'operating_hours',
        'is_active',
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'is_active' => 'boolean',
        'is_inside_mall' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

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
}
