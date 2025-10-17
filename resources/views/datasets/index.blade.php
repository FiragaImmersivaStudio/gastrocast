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
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning process-btn" onclick="processDataset({{ $dataset->id }})" title="Reprocess Dataset">
                                            <i class="fas fa-redo me-1"></i>Reprocess
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="showError({{ $dataset->id }}, '{{ addslashes($dataset->validation_errors) }}')" title="View Error Details">
                                            <i class="fas fa-exclamation-circle me-1"></i>View Error
                                        </button>
                                    </div>
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

async function processDataset(datasetId) {
    const btn = event.target.closest('button');
    const isReprocess = btn.innerHTML.includes('Reprocess');
    const confirmMessage = isReprocess 
        ? 'Apakah Anda yakin ingin memproses ulang dataset ini? Ini akan mencoba kembali mengimpor data.'
        : 'Apakah Anda yakin ingin memproses dataset ini? Ini akan mengimpor data ke database restoran Anda.';
    const confirmTitle = isReprocess ? 'Konfirmasi Proses Ulang' : 'Konfirmasi Proses Dataset';
    const confirmButtonText = isReprocess ? 'Ya, Proses Ulang' : 'Ya, Proses';
    
    const confirmed = await confirmAction(confirmMessage, confirmTitle, confirmButtonText, 'Batal');
    
    if (!confirmed) {
        return;
    }
    
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>' + (isReprocess ? 'Memproses ulang...' : 'Memulai...');
    
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
            // Show success message
            showSuccessToast(data.message);
            
            // Update the row
            const row = document.querySelector(`tr[data-dataset-id="${datasetId}"]`);
            const statusCell = row.querySelector('.status-cell');
            const actionCell = row.querySelector('.action-cell');
            
            statusCell.innerHTML = '<span class="badge bg-warning">Processing...</span>';
            actionCell.innerHTML = '<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-spinner fa-spin me-1"></i>Processing...</button><button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteDataset(' + datasetId + ')"><i class="fas fa-trash"></i></button>';
            
            // Poll for status updates
            pollDatasetStatus(datasetId);
        } else {
            showErrorToast('Failed to start ' + (isReprocess ? 'reprocessing' : 'processing') + ': ' + (data.error || data.message));
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        showErrorToast('Network error: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function pollDatasetStatus(datasetId) {
    const interval = setInterval(() => {
        fetch(`/datasets/${datasetId}/status`, {
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'processing') {
                clearInterval(interval);
                updateDatasetRow(datasetId, data);
            }
        })
        .catch(() => {
            clearInterval(interval);
        });
    }, 2000); // Poll every 2 seconds
}

function updateDatasetRow(datasetId, data) {
    const row = document.querySelector(`tr[data-dataset-id="${datasetId}"]`);
    if (!row) return;

    const statusCell = row.querySelector('.status-cell');
    const actionCell = row.querySelector('.action-cell');
    
    // Update status badge
    let statusBadge = '';
    switch(data.status) {
        case 'completed':
            statusBadge = '<span class="badge bg-success">Completed</span>';
            showSuccessToast('Dataset processed successfully!');
            break;
        case 'failed':
            statusBadge = '<span class="badge bg-danger">Failed</span>';
            showErrorToast('Dataset processing failed. Check error details and try reprocessing.');
            break;
        default:
            statusBadge = `<span class="badge bg-info">${data.status}</span>`;
    }
    statusCell.innerHTML = statusBadge;

    // Update action buttons
    let actionButtons = '';
    if (data.status === 'completed') {
        actionButtons = `
            <a href="/datasets/${datasetId}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye me-1"></i>Detail
            </a>
        `;
    } else if (data.status === 'failed') {
        actionButtons = `
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-warning process-btn" onclick="processDataset(${datasetId})" title="Reprocess Dataset">
                    <i class="fas fa-redo me-1"></i>Reprocess
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="showError(${datasetId}, '${data.validation_errors ? data.validation_errors.replace(/'/g, "\\'") : 'Unknown error'}')" title="View Error Details">
                    <i class="fas fa-exclamation-circle me-1"></i>View Error
                </button>
            </div>
        `;
    } else if (data.status === 'uploaded') {
        actionButtons = `
            <button class="btn btn-sm btn-primary process-btn" onclick="processDataset(${datasetId})">
                <i class="fas fa-play me-1"></i>Process
            </button>
        `;
    }
    
    actionButtons += `
        <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteDataset(${datasetId})">
            <i class="fas fa-trash"></i>
        </button>
    `;
    
    actionCell.innerHTML = actionButtons;
}

async function deleteDataset(datasetId) {
    const confirmed = await confirmAction(
        'Apakah Anda yakin ingin menghapus dataset ini? Ini juga akan menghapus semua data terkait (pesanan, item menu, item inventori). Tindakan ini tidak dapat dibatalkan.',
        'Konfirmasi Hapus Dataset',
        'Ya, Hapus',
        'Batal'
    );
    
    if (!confirmed) {
        return;
    }
    
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
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
            showSuccessToast(data.message);
            
            // Optional: Show deletion details if available
            if (data.deleted_counts && Object.values(data.deleted_counts).some(count => count > 0)) {
                console.log('Deletion details:', data.deleted_counts);
            }
            
            // Reload after a short delay to show the toast
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showErrorToast('Failed to delete dataset: ' + (data.error || data.message));
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    })
    .catch(error => {
        showErrorToast('Error deleting dataset: ' + error.message);
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function showError(datasetId, error) {
    // Create a modal to show detailed error
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Dataset Processing Error
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2"><strong>Error Details:</strong></p>
                    <div class="alert alert-danger">
                        <pre class="mb-0" style="white-space: pre-wrap; font-size: 0.9em;">${error}</pre>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        You can try to reprocess this dataset by clicking the "Reprocess" button.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="processDataset(${datasetId}); bootstrap.Modal.getInstance(this.closest('.modal')).hide();">
                        <i class="fas fa-redo me-1"></i>Reprocess Now
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    modal.addEventListener('hidden.bs.modal', () => modal.remove());
}

function showSuccessToast(message) {
    const toast = createToast('success', message);
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

function showErrorToast(message) {
    const toast = createToast('danger', message);
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

function createToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
    return toast;
}
</script>
@endsection
