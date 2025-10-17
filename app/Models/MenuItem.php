<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'category_id',
        'sku',
        'name',
        'description',
        'price',
        'cogs',
        'is_active',
        'prep_time_minutes',
        'allergens',
        'nutrition_info',
        'dataset_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cogs' => 'decimal:2',
        'is_active' => 'boolean',
        'allergens' => 'array',
        'nutrition_info' => 'array',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
