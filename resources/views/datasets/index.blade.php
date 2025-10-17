@extends('layouts.app')

@section('title', 'Datasets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <div>
        <h1>Dataset Management</h1>
        <p class="text-muted mb-0">Kelola dan impor data untuk analisis restoran Anda. Gunakan fitur ini untuk mengupload data penjualan, menu, inventori, dan customer.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="fas fa-upload me-2"></i>Import Data
    </button>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-receipt fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Sales Data</h5>
                @php
                    $salesCount = $datasets->where('type', 'sales')->where('status', 'completed')->sum('total_records');
                @endphp
                <p class="text-muted">{{ number_format($salesCount) }} records</p>
                <div class="mt-2">
                    <a href="{{ route('datasets.template', 'sales') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download me-1"></i>Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Customer Data</h5>
                @php
                    $customersCount = $datasets->where('type', 'customers')->where('status', 'completed')->sum('total_records');
                @endphp
                <p class="text-muted">{{ number_format($customersCount) }} records</p>
                <div class="mt-2">
                    <a href="{{ route('datasets.template', 'customers') }}" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-download me-1"></i>Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-utensils fa-2x text-success mb-2"></i>
                <h5 class="card-title">Menu Items</h5>
                @php
                    $menuCount = $datasets->where('type', 'menu')->where('status', 'completed')->sum('total_records');
                @endphp
                <p class="text-muted">{{ number_format($menuCount) }} records</p>
                <div class="mt-2">
                    <a href="{{ route('datasets.template', 'menu') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-download me-1"></i>Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-boxes fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Inventory</h5>
                @php
                    $inventoryCount = $datasets->where('type', 'inventory')->where('status', 'completed')->sum('total_records');
                @endphp
                <p class="text-muted">{{ number_format($inventoryCount) }} records</p>
                <div class="mt-2">
                    <a href="{{ route('datasets.template', 'inventory') }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-download me-1"></i>Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Upload History</h5>
    </div>
    <div class="card-body">
        @if($datasets->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada dataset yang diupload. Klik tombol "Import Data" untuk mulai.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Upload Date</th>
                            <th>Data Type</th>
                            <th>Filename</th>
                            <th>Records</th>
                            <th>Date Range</th>
                            <th>Uploaded By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datasets as $dataset)
                        <tr data-dataset-id="{{ $dataset->id }}">
                            <td>{{ $dataset->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                @switch($dataset->type)
                                    @case('sales')
                                        <i class="fas fa-receipt text-primary me-1"></i>Sales
                                        @break
                                    @case('customers')
                                        <i class="fas fa-users text-info me-1"></i>Customers
                                        @break
                                    @case('menu')
                                        <i class="fas fa-utensils text-success me-1"></i>Menu
                                        @break
                                    @case('inventory')
                                        <i class="fas fa-boxes text-warning me-1"></i>Inventory
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $dataset->filename }}</td>
                            <td>{{ number_format($dataset->total_records) }}</td>
                            <td>
                                @if($dataset->data_start_date && $dataset->data_end_date)
                                    {{ $dataset->data_start_date->format('Y-m-d') }} - {{ $dataset->data_end_date->format('Y-m-d') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $dataset->uploadedBy->name ?? 'Unknown' }}</td>
                            <td class="status-cell">
                                @switch($dataset->status)
                                    @case('uploaded')
                                        <span class="badge bg-info">Uploaded</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-warning">Processing...</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="action-cell">
                                @if($dataset->status === 'uploaded')
                                    <button class="btn btn-sm btn-primary process-btn" onclick="processDataset({{ $dataset->id }})">
                                        <i class="fas fa-play me-1"></i>Process
                                    </button>
                                @elseif($dataset->status === 'processing')
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-spinner fa-spin me-1"></i>Processing...
                                    </button>
                                @elseif($dataset->status === 'completed')
                                    <a href="{{ route('datasets.show', $dataset->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                @elseif($dataset->status === 'failed')
                                    <button class="btn btn-sm btn-outline-danger" onclick="showError({{ $dataset->id }}, '{{ addslashes($dataset->validation_errors) }}')">
                                        <i class="fas fa-exclamation-circle me-1"></i>View Error
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteDataset({{ $dataset->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $datasets->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="dataType" class="form-label">Data Type</label>
                        <select class="form-select" id="dataType" name="type" required>
                            <option value="">Select data type</option>
                            <option value="sales">Sales Transactions</option>
                            <option value="customers">Customer Data</option>
                            <option value="menu">Menu Items</option>
                            <option value="inventory">Inventory</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dataFile" class="form-label">File</label>
                        <input type="file" class="form-control" id="dataFile" name="file" accept=".xlsx" required>
                        <div class="form-text">Only XLSX format is supported. Download template above for reference.</div>
                    </div>
                    <div id="uploadError" class="alert alert-danger d-none"></div>
                    <div id="uploadProgress" class="d-none">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                        <p class="text-center mt-2 mb-0">Uploading...</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitImport">Import Data</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('submitImport').addEventListener('click', function() {
    const form = document.getElementById('importForm');
    const formData = new FormData(form);
    const submitBtn = this;
    const errorDiv = document.getElementById('uploadError');
    const progressDiv = document.getElementById('uploadProgress');
    
    // Validate
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Disable button and show progress
    submitBtn.disabled = true;
    errorDiv.classList.add('d-none');
    progressDiv.classList.remove('d-none');
    
    fetch('{{ route("datasets.upload") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and reload page
            const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
            modal.hide();
            location.reload();
        } else {
            errorDiv.textContent = data.error + (data.details ? ': ' + data.details.join(', ') : '');
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(error => {
        errorDiv.textContent = 'Failed to upload dataset: ' + error.message;
        errorDiv.classList.remove('d-none');
    })
    .finally(() => {
        submitBtn.disabled = false;
        progressDiv.classList.add('d-none');
    });
});

function processDataset(datasetId) {
    if (!confirm('Are you sure you want to process this dataset? This will import the data into your restaurant database.')) {
        return;
    }
    
    const btn = event.target.closest('button');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Starting...';
    
    fetch(`/datasets/${datasetId}/process`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the row
            const row = document.querySelector(`tr[data-dataset-id="${datasetId}"]`);
            const statusCell = row.querySelector('.status-cell');
            const actionCell = row.querySelector('.action-cell');
            
            statusCell.innerHTML = '<span class="badge bg-warning">Processing...</span>';
            actionCell.innerHTML = '<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-spinner fa-spin me-1"></i>Processing...</button>';
            
            // Poll for status updates
            pollDatasetStatus(datasetId);
        } else {
            alert('Failed to start processing: ' + data.error);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-play me-1"></i>Process';
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-play me-1"></i>Process';
    });
}

function pollDatasetStatus(datasetId) {
    const interval = setInterval(() => {
        fetch(`/datasets/${datasetId}`, {
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'processing') {
                clearInterval(interval);
                location.reload();
            }
        })
        .catch(() => {
            clearInterval(interval);
        });
    }, 3000); // Poll every 3 seconds
}

function deleteDataset(datasetId) {
    if (!confirm('Are you sure you want to delete this dataset? This action cannot be undone.')) {
        return;
    }
    
    fetch(`/datasets/${datasetId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to delete dataset: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

function showError(datasetId, error) {
    alert('Dataset processing failed:\n\n' + error);
}
</script>
@endsection
