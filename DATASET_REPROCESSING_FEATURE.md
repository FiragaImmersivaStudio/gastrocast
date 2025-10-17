# 🔄 Dataset Reprocessing Feature

## Feature Overview

Dataset yang gagal diproses (`status: failed`) sekarang dapat diproses ulang tanpa perlu upload ulang file.

## Changes Made

### ✅ 1. Enhanced Dataset Model

**File:** `app/Models/Dataset.php`

#### Updated `canBeProcessed()` Method
```php
// Before: Only 'uploaded' status allowed
public function canBeProcessed()
{
    return $this->status === 'uploaded';
}

// After: Both 'uploaded' and 'failed' status allowed
public function canBeProcessed()
{
    return in_array($this->status, ['uploaded', 'failed']);
}
```

#### Added New Methods
```php
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
```

### ✅ 2. Enhanced DatasetController

**File:** `app/Http/Controllers/DatasetController.php`

#### Updated `process()` Method
- ✅ Better error messages with detailed status information
- ✅ Automatic reset of failed datasets before reprocessing
- ✅ Different success messages for new vs. reprocessing
- ✅ Enhanced response data with reprocess capability info

#### Added `status()` Method
```php
/**
 * Get dataset status for polling
 */
public function status($id)
{
    // Returns comprehensive status information including:
    // - Current status and timestamps
    // - Error messages and processing notes  
    // - Reprocessing capability flags
    // - Processing state booleans
}
```

### ✅ 3. Updated Routes

**File:** `routes/web.php`

```php
// Added new route for status polling
Route::get('/datasets/{id}/status', [DatasetController::class, 'status'])->name('datasets.status');
```

## Usage Scenarios

### 📊 Status Transitions

```
Normal Flow:
uploaded → processing → completed ✅

Error Flow with Reprocessing:
uploaded → processing → failed → [USER CLICKS REPROCESS] → uploaded → processing → completed ✅
```

### 🔄 Reprocessing Workflow

1. **Dataset Fails Processing**
   ```json
   {
     "status": "failed",
     "validation_errors": "Error message here",
     "can_reprocess": true
   }
   ```

2. **User Clicks Reprocess Button**
   - System calls `/datasets/{id}/process` endpoint
   - Dataset automatically reset to 'uploaded' status
   - Processing job dispatched again

3. **Success Response**
   ```json
   {
     "success": true,
     "message": "Dataset reprocessing started",
     "dataset": {
       "id": 1,
       "status": "processing", 
       "can_reprocess": false
     }
   }
   ```

### 📡 Status Polling

Frontend can poll the status endpoint for real-time updates:
```javascript
// Poll every 2 seconds during processing
setInterval(() => {
  fetch(`/datasets/${datasetId}/status`)
    .then(response => response.json())
    .then(data => {
      updateUI(data);
      if (data.is_completed || data.is_failed) {
        clearInterval(polling);
      }
    });
}, 2000);
```

## Benefits

### ✅ User Experience
- **No Re-upload Required**: Users don't need to upload the same file again
- **Preserve File History**: Original upload timestamp and metadata preserved
- **Clear Status**: Better feedback on what's happening and what's possible

### ✅ System Efficiency  
- **Resource Optimization**: No duplicate file storage
- **Error Recovery**: Automatic cleanup of error state before reprocessing
- **Audit Trail**: Complete history of processing attempts maintained

### ✅ Development
- **Better Debugging**: Enhanced error messages and status information
- **Flexible Processing**: Easy to extend with retry policies
- **API Consistency**: RESTful status polling endpoint

## Status: ✅ READY FOR USE

The reprocessing feature is now fully functional and ready for production use. Users can:

- ✅ View failed datasets in the dataset list
- ✅ Click "Process" button on failed datasets  
- ✅ Get clear feedback about reprocessing vs. initial processing
- ✅ Monitor processing status with enhanced polling
- ✅ Automatic cleanup of previous error state

**Failed datasets are no longer dead-ends - they can be easily recovered!** 🚀