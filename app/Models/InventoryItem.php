<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'sku',
        'name',
        'description',
        'uom',
        'current_stock',
        'safety_stock',
        'reorder_point',
        'unit_cost',
        'supplier',
        'lead_time_days',
        'is_active',
        'dataset_id',
    ];

    protected $casts = [
        'current_stock' => 'decimal:3',
        'safety_stock' => 'decimal:3',
        'reorder_point' => 'decimal:3',
        'unit_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
