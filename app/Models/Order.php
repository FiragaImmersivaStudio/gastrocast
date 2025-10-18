<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'order_no',
        'order_dt',
        'channel',
        'status',
        'gross_amount',
        'net_amount',
        'tax_amount',
        'discount_amount',
        'waiting_time_sec',
        'party_size',
        'customer_name',
        'customer_phone',
        'payment_method',
        'notes',
        'dataset_id',
        'weather_temp',
        'weather_condition',
        'weather_description',
        'weather_humidity',
        'weather_pressure',
        'weather_wind_speed',
        'weather_fetched_at',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
