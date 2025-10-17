# Dataset Management Implementation

This document describes the implementation of the dataset management functionality for the GastroCast application.

## Features Implemented

### 1. Upload History with Dates
- Every dataset upload is recorded with timestamp
- Upload history is displayed in a table showing all past uploads
- Uploaded by user is tracked for each dataset

### 2. Auto-Detection of Date Ranges
- When a dataset is uploaded, the system automatically detects the date range of the data
- Date range is extracted from the date column in the dataset
- Displayed in the format: YYYY-MM-DD to YYYY-MM-DD

### 3. XLSX Templates
- Sample XLSX templates are provided for each dataset type:
  - Sales Transactions
  - Customer Data
  - Menu Items
  - Inventory
- Templates include proper column headers and example data
- Users can download templates from the dataset management page

### 4. File Validation
- Uploaded files are validated against expected column structure
- Only XLSX format is accepted
- Missing columns are reported as validation errors
- Invalid files are rejected before being stored

### 5. Process Button and Status Tracking
- Datasets are uploaded but not immediately processed
- User must click "Process" button to start processing
- Status tracking:
  - **Uploaded**: Dataset uploaded, ready to process
  - **Processing...**: Dataset is being processed (button disabled with spinner)
  - **Completed**: Processing finished successfully, "Detail" button available
  - **Failed**: Processing failed, "View Error" button shows error details

### 6. Queue-Based Processing
- Processing is handled by Laravel Jobs (async)
- Long-running processes don't block the web interface
- Jobs table created for queue management
- Status polling implemented for real-time updates

### 7. Detail View
- After successful processing, users can click "Detail" button
- Detail page shows:
  - Dataset metadata (type, filename, records, dates, status)
  - Restaurant information
  - Data preview (first 10 rows)
  - Processing notes and errors (if any)

### 8. Dataset Relationship Flagging
- `dataset_id` field added to related tables:
  - `orders`
  - `menu_items`
  - `inventory_items`
- Each imported record is linked to its source dataset
- Enables tracking data lineage and audit trails

## Database Schema

### datasets Table
```
- id: Primary key
- restaurant_id: Foreign key to restaurants
- uploaded_by: Foreign key to users
- type: Enum (sales, customers, menu, inventory)
- filename: Original filename
- file_path: Storage path
- total_records: Number of records in dataset
- data_start_date: Auto-detected start date
- data_end_date: Auto-detected end date
- status: Enum (uploaded, processing, completed, failed)
- validation_errors: Text field for errors
- processing_notes: Text field for notes
- processed_at: Timestamp of completion
- created_at, updated_at: Standard timestamps
```

### jobs Table (for queue)
```
- id: Primary key
- queue: Queue name
- payload: Job data
- attempts: Retry count
- reserved_at: When job was picked up
- available_at: When job becomes available
- created_at: When job was created
```

## File Structure

### Controllers
- `app/Http/Controllers/DatasetController.php`: Main controller handling all dataset operations

### Models
- `app/Models/Dataset.php`: Dataset model with relationships
- `app/Models/Order.php`: Updated with dataset_id
- `app/Models/MenuItem.php`: Updated with dataset_id
- `app/Models/InventoryItem.php`: Updated with dataset_id

### Jobs
- `app/Jobs/ProcessDataset.php`: Async job for processing datasets

### Views
- `resources/views/datasets/index.blade.php`: Main dataset management page
- `resources/views/datasets/show.blade.php`: Dataset detail page

### Migrations
- `database/migrations/*_create_datasets_table.php`: Creates datasets table
- `database/migrations/*_create_jobs_table.php`: Creates jobs table for queue
- `database/migrations/*_add_dataset_id_to_related_tables.php`: Adds dataset_id to related tables

### Routes
- `GET /datasets`: List all datasets
- `POST /datasets/upload`: Upload new dataset
- `POST /datasets/{id}/process`: Start processing dataset
- `GET /datasets/{id}`: View dataset details
- `DELETE /datasets/{id}`: Delete dataset
- `GET /datasets/template/{type}`: Download XLSX template

## Setup Instructions

### 1. Install Dependencies
```bash
composer install
```

### 2. Run Migrations
```bash
php artisan migrate
```

### 3. Configure Queue Driver (Optional but Recommended)
Update `.env` file:
```
QUEUE_CONNECTION=database
```

### 4. Start Queue Worker (if using database queue)
```bash
php artisan queue:work
```

### 5. Create Storage Directory
```bash
php artisan storage:link
mkdir -p storage/app/datasets
```

## Usage Flow

1. User navigates to Datasets page
2. User clicks "Import Data" button
3. User selects dataset type and uploads XLSX file
4. System validates file structure and extracts date range
5. Dataset is saved with "uploaded" status
6. User clicks "Process" button
7. System dispatches job to queue and sets status to "processing"
8. Job processes data and imports records to database
9. Status changes to "completed" or "failed"
10. User can view details or download results

## Dataset Types and Expected Columns

### Sales Transactions
- order_id, date, time, customer_name, menu_item, quantity, unit_price, total_amount, payment_method, status

### Customer Data
- customer_id, name, email, phone, registration_date, total_orders, total_spent, status

### Menu Items
- item_id, name, category, description, price, cost, status, allergens, prep_time

### Inventory
- item_name, category, unit, current_stock, minimum_stock, unit_cost, supplier, last_updated

## Security Features

- CSRF protection on all forms
- File type validation (XLSX only)
- Restaurant ownership verification
- User authentication required
- File size limit (10MB)
- SQL injection protection via Eloquent ORM

## Dependencies Added

- `phpoffice/phpspreadsheet` (^2.3.5): For reading and creating XLSX files
  - Version chosen to avoid security vulnerabilities
  - Used for template generation and file validation
