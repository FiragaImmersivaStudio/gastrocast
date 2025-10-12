@extends('layouts.app')

@section('title', 'Datasets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <div>
        <h1>Dataset Management</h1>
        <p class="text-muted mb-0">Kelola dan impor data untuk analisis restoran Anda. Gunakan fitur ini untuk mengupload data penjualan, menu, inventori, dan staff.</p>
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
                <p class="text-muted">12,450 records</p>
                <span class="badge bg-success mb-2">Up to date</span>
                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="downloadSample('sales')">
                        <i class="fas fa-download me-1"></i>Download Sample
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Customer Data</h5>
                <p class="text-muted">3,280 records</p>
                <span class="badge bg-warning mb-2">Pending sync</span>
                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-info" onclick="downloadSample('sales')">
                        <i class="fas fa-download me-1"></i>Download Sample
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-utensils fa-2x text-success mb-2"></i>
                <h5 class="card-title">Menu Items</h5>
                <p class="text-muted">156 items</p>
                <span class="badge bg-success mb-2">Up to date</span>
                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-success" onclick="downloadSample('menu')">
                        <i class="fas fa-download me-1"></i>Download Sample
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-boxes fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Inventory</h5>
                <p class="text-muted">89 items</p>
                <span class="badge bg-success mb-2">Up to date</span>
                <div class="mt-2">
                    <button class="btn btn-sm btn-outline-warning" onclick="downloadSample('inventory')">
                        <i class="fas fa-download me-1"></i>Download Sample
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Recent Data Imports</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Import Date</th>
                        <th>Data Type</th>
                        <th>Records</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15 10:30:00</td>
                        <td>Sales Transactions</td>
                        <td>1,250</td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-14 15:45:00</td>
                        <td>Customer Data</td>
                        <td>145</td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-13 09:15:00</td>
                        <td>Menu Updates</td>
                        <td>25</td>
                        <td><span class="badge bg-warning">Processing</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" disabled>Processing...</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
                <form id="importForm">
                    <div class="mb-3">
                        <label for="dataType" class="form-label">Data Type</label>
                        <select class="form-select" id="dataType" required>
                            <option value="">Select data type</option>
                            <option value="sales">Sales Transactions</option>
                            <option value="customers">Customer Data</option>
                            <option value="menu">Menu Items</option>
                            <option value="inventory">Inventory</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dataFile" class="form-label">File</label>
                        <input type="file" class="form-control" id="dataFile" accept=".csv,.xlsx,.json" required>
                        <div class="form-text">Supported formats: CSV, Excel, JSON</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitImport()">Import Data</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function submitImport() {
    // Simulate import process
    alert('Data import started! You will be notified when it completes.');
    $('#importModal').modal('hide');
    document.getElementById('importForm').reset();
}

function downloadSample(type) {
    // Create a temporary anchor element to trigger download
    const downloadUrl = `/api/sample-data/download/${type}`;
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endpush