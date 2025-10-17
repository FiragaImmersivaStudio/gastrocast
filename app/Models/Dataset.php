<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'uploaded_by',
        'type',
        'filename',
        'file_path',
        'total_records',
        'data_start_date',
        'data_end_date',
        'status',
        'validation_errors',
        'processing_notes',
        'processed_at',
    ];

    protected $casts = [
        'data_start_date' => 'date',
        'data_end_date' => 'date',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the restaurant that owns the dataset
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the user who uploaded the dataset
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get orders imported from this dataset
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get menu items imported from this dataset
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get inventory items imported from this dataset
     */
    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    /**
     * Check if dataset is processing
     */
    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    /**
     * Check if dataset is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if dataset failed
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Check if dataset can be processed
     */
    public function canBeProcessed()
    {
        return in_array($this->status, ['uploaded', 'failed']);
    }

    /**
     * Reset dataset for reprocessing
     */
    public function resetForReprocessing()
    {
        $this->update([
            'status' => 'uploaded',
            'validation_errors' => null,
            'processing_notes' => null,
            'processed_at' => null,
        ]);
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'uploaded' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-yellow-100 text-yellow-800', 
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
