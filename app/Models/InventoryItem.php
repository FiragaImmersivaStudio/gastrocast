<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'category',
        'unit',
        'current_stock',
        'minimum_stock',
        'unit_cost',
        'supplier',
        'last_updated',
        'dataset_id',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'last_updated' => 'datetime',
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
