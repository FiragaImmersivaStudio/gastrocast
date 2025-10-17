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
        return $this->status === 'uploaded';
    }
}
