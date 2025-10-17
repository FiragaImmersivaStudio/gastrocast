# Dataset Management - Quick Start Guide

## Overview

The Dataset Management system allows you to import data from XLSX files into your restaurant database. This feature supports four types of datasets:

- **Sales Transactions** 📊
- **Customer Data** 👥  
- **Menu Items** 🍽️
- **Inventory** 📦

## How It Works

```
┌─────────────┐      ┌──────────────┐      ┌─────────────┐      ┌──────────────┐
│   Upload    │ ───> │   Validate   │ ───> │   Process   │ ───> │   Complete   │
│   Dataset   │      │   Structure  │      │   (Queue)   │      │   w/ Detail  │
└─────────────┘      └──────────────┘      └─────────────┘      └──────────────┘
     Step 1               Step 2                Step 3               Step 4
```

### Step 1: Upload Dataset

1. Click **"Import Data"** button
2. Select dataset type (Sales, Customers, Menu, or Inventory)
3. Choose XLSX file from your computer
4. System validates:
   - File format (must be XLSX)
   - Column structure (matches expected headers)
   - Data integrity
5. If valid, dataset is saved with status: **Uploaded**

### Step 2: Automatic Detection

The system automatically:
- Counts total records
- Detects date range from your data
- Stores who uploaded it and when

### Step 3: Process Dataset

1. Click **"Process"** button on uploaded dataset
2. Button becomes **"Processing..."** (disabled)
3. Job is queued for background processing
4. Data is imported into database tables
5. Each record is linked to the source dataset

### Step 4: View Details

1. When processing completes, button becomes **"Detail"**
2. Click to see:
   - Dataset metadata
   - Date ranges
   - Processing results
   - Data preview (first 10 rows)

## Dataset Templates

Download XLSX templates to see the required column structure:

### Sales Transactions
```
order_id | date | time | customer_name | menu_item | quantity | unit_price | total_amount | payment_method | status
```

### Customer Data
```
customer_id | name | email | phone | registration_date | total_orders | total_spent | status
```

### Menu Items
```
item_id | name | category | description | price | cost | status | allergens | prep_time
```

### Inventory
```
item_name | category | unit | current_stock | minimum_stock | unit_cost | supplier | last_updated
```

## Status Indicators

| Status | Badge | Description |
|--------|-------|-------------|
| Uploaded | 🔵 Blue | Dataset uploaded, ready to process |
| Processing | 🟡 Yellow | Currently being processed |
| Completed | 🟢 Green | Successfully processed, view details |
| Failed | 🔴 Red | Processing failed, view error |

## Important Notes

### File Format
- **Only XLSX files** are accepted
- Maximum file size: **10MB**
- All columns in template must be present

### Data Integrity
- Each imported record is linked to its source dataset via `dataset_id`
- You can track which records came from which upload
- Duplicate prevention: system checks before inserting

### Processing Time
- Small datasets (< 1000 rows): ~1-2 seconds
- Medium datasets (1000-5000 rows): ~5-10 seconds  
- Large datasets (> 5000 rows): may take several minutes

### Queue System
For best performance, configure Laravel Queue:

```env
QUEUE_CONNECTION=database
```

Then run the queue worker:
```bash
php artisan queue:work
```

Without queue worker, processing happens synchronously (may timeout on large datasets).

## Troubleshooting

### "Invalid file structure" Error
**Cause**: Column headers don't match template  
**Solution**: Download template and use exact column names

### "Processing..." Never Completes
**Cause**: Queue worker not running  
**Solution**: Start queue worker with `php artisan queue:work`

### File Upload Fails
**Cause**: File too large or wrong format  
**Solution**: 
- Ensure file is XLSX format
- Check file size is under 10MB
- Verify PHP upload limits in php.ini

### Date Range Shows "N/A"
**Cause**: Date column is empty or in wrong format  
**Solution**: Ensure date columns have valid dates

## API Endpoints

For programmatic access:

```
GET    /datasets                    # List all datasets
POST   /datasets/upload             # Upload new dataset
POST   /datasets/{id}/process       # Start processing
GET    /datasets/{id}               # View details
DELETE /datasets/{id}               # Delete dataset
GET    /datasets/template/{type}    # Download template
```

## Database Schema

Imported data goes to:
- Sales → `orders` and `order_items` tables
- Menu → `menu_items` table
- Inventory → `inventory_items` table
- Customers → (logged, not yet stored in separate table)

All records include `dataset_id` to track source.

## Support

For issues or questions:
1. Check the error message in "View Error" button
2. Review DATASET_IMPLEMENTATION.md for technical details
3. Contact system administrator

---

**Pro Tip**: Start with a small test dataset (10-20 rows) to verify the structure before uploading larger files!
