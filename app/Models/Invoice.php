<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'amount',
        'currency',
        'status',
        'due_date',
        'paid_at',
        'billing_details',
        'payment_method',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'billing_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
