@extends('layouts.app')

@section('title', 'Reports & Export')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Reports & Export</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateReportModal">
        <i class="fas fa-file-alt me-2"></i>Generate Report
    </button>
</div>

<!-- Quick Reports -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-chart-bar fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Sales Summary</h5>
                <p class="text-muted">Daily, weekly, monthly sales</p>
                <button class="btn btn-sm btn-outline-primary" onclick="generateQuickReport('sales')">Generate</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-utensils fa-2x text-success mb-2"></i>
                <h5 class="card-title">Menu Performance</h5>
                <p class="text-muted">Top selling items analysis</p>
                <button class="btn btn-sm btn-outline-success" onclick="generateQuickReport('menu')">Generate</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Customer Insights</h5>
                <p class="text-muted">Demographics and behavior</p>
                <button class="btn btn-sm btn-outline-info" onclick="generateQuickReport('customers')">Generate</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-boxes fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Inventory Report</h5>
                <p class="text-muted">Stock levels and usage</p>
                <button class="btn btn-sm btn-outline-warning" onclick="generateQuickReport('inventory')">Generate</button>
            </div>
        </div>
    </div>
</div>

<!-- Report History -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Report History</h5>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-secondary active">All</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Sales</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Menu</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Custom</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>Type</th>
                        <th>Date Range</th>
                        <th>Generated</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Weekly Sales Report</strong></td>
                        <td><span class="badge bg-primary">Sales</span></td>
                        <td>Jan 8-14, 2024</td>
                        <td>2024-01-15 09:30</td>
                        <td>2.3 MB</td>
                        <td><span class="badge bg-success">Ready</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="downloadReport(1)">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="shareReport(1)">
                                <i class="fas fa-share"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-info" onclick="scheduleReport(1)">
                                <i class="fas fa-clock"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Menu Performance Analysis</strong></td>
                        <td><span class="badge bg-success">Menu</span></td>
                        <td>December 2023</td>
                        <td>2024-01-12 14:20</td>
                        <td>1.8 MB</td>
                        <td><span class="badge bg-success">Ready</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="downloadReport(2)">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="shareReport(2)">
                                <i class="fas fa-share"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-info" onclick="scheduleReport(2)">
                                <i class="fas fa-clock"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Customer Demographics</strong></td>
                        <td><span class="badge bg-info">Customer</span></td>
                        <td>Q4 2023</td>
                        <td>2024-01-10 11:45</td>
                        <td>950 KB</td>
                        <td><span class="badge bg-warning">Processing</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="fas fa-spinner fa-spin"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Inventory Status Report</strong></td>
                        <td><span class="badge bg-warning">Inventory</span></td>
                        <td>Current</td>
                        <td>2024-01-08 16:00</td>
                        <td>1.2 MB</td>
                        <td><span class="badge bg-success">Ready</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="downloadReport(4)">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="shareReport(4)">
                                <i class="fas fa-share"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-info" onclick="scheduleReport(4)">
                                <i class="fas fa-clock"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scheduled Reports -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Scheduled Reports</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-light">
                    <div class="card-body">
                        <h6 class="card-title">Weekly Sales Summary</h6>
                        <p class="card-text">
                            <small class="text-muted">Every Monday at 9:00 AM</small><br>
                            <small>Next run: Jan 22, 2024</small>
                        </p>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-primary" onclick="editSchedule(1)">Edit</button>
                            <button class="btn btn-outline-secondary" onclick="pauseSchedule(1)">Pause</button>
                            <button class="btn btn-outline-danger" onclick="deleteSchedule(1)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-light">
                    <div class="card-body">
                        <h6 class="card-title">Monthly Performance</h6>
                        <p class="card-text">
                            <small class="text-muted">1st of every month at 8:00 AM</small><br>
                            <small>Next run: Feb 1, 2024</small>
                        </p>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-primary" onclick="editSchedule(2)">Edit</button>
                            <button class="btn btn-outline-secondary" onclick="pauseSchedule(2)">Pause</button>
                            <button class="btn btn-outline-danger" onclick="deleteSchedule(2)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generate Report Modal -->
<div class="modal fade" id="generateReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Custom Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reportName" class="form-label">Report Name</label>
                                <input type="text" class="form-control" id="reportName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reportType" class="form-label">Report Type</label>
                                <select class="form-select" id="reportType" required>
                                    <option value="">Select type</option>
                                    <option value="sales">Sales Analysis</option>
                                    <option value="menu">Menu Performance</option>
                                    <option value="customer">Customer Analysis</option>
                                    <option value="inventory">Inventory Report</option>
                                    <option value="financial">Financial Summary</option>
                                    <option value="custom">Custom Report</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Include Sections</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeSummary" checked>
                                    <label class="form-check-label" for="includeSummary">Executive Summary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeCharts" checked>
                                    <label class="form-check-label" for="includeCharts">Charts & Graphs</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeDetails">
                                    <label class="form-check-label" for="includeDetails">Detailed Data</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeComparisons">
                                    <label class="form-check-label" for="includeComparisons">Period Comparisons</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeRecommendations">
                                    <label class="form-check-label" for="includeRecommendations">AI Recommendations</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeForecasts">
                                    <label class="form-check-label" for="includeForecasts">Future Forecasts</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exportFormat" class="form-label">Export Format</label>
                        <select class="form-select" id="exportFormat" required>
                            <option value="pdf">PDF Document</option>
                            <option value="excel">Excel Spreadsheet</option>
                            <option value="csv">CSV Data</option>
                            <option value="powerpoint">PowerPoint Presentation</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success me-2" onclick="generateAndSchedule()">Generate & Schedule</button>
                <button type="button" class="btn btn-primary" onclick="generateReport()">Generate Now</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function generateQuickReport(type) {
    alert(`Generating ${type} report... You'll receive an email when it's ready.`);
}

function generateReport() {
    alert('Report generation started! You will receive an email notification when it\'s ready.');
    $('#generateReportModal').modal('hide');
    document.getElementById('reportForm').reset();
}

function generateAndSchedule() {
    alert('Report generated and scheduled successfully!');
    $('#generateReportModal').modal('hide');
    document.getElementById('reportForm').reset();
}

function downloadReport(id) {
    alert(`Downloading report ${id}...`);
}

function shareReport(id) {
    alert(`Opening share options for report ${id}`);
}

function scheduleReport(id) {
    alert(`Setting up schedule for report ${id}`);
}

function editSchedule(id) {
    alert(`Editing schedule ${id}`);
}

function pauseSchedule(id) {
    alert(`Schedule ${id} paused`);
}

function deleteSchedule(id) {
    if (confirm('Are you sure you want to delete this scheduled report?')) {
        alert(`Schedule ${id} deleted`);
    }
}
</script>
@endpush