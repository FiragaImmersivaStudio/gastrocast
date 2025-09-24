@extends('layouts.app')

@section('title', 'What-If Lab - GastroCast')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>What-If Lab</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newScenarioModal">
        <i class="fas fa-flask me-2"></i>Create Scenario
    </button>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Scenario Comparison</h5>
            </div>
            <div class="card-body">
                <canvas id="scenarioChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Active Scenarios</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">20% Price Increase</h6>
                            <small class="text-muted">Menu items +20%</small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewScenario(1)">View</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Extended Hours</h6>
                            <small class="text-muted">Open until 11 PM</small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewScenario(2)">View</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">New Location</h6>
                            <small class="text-muted">Downtown branch</small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="viewScenario(3)">View</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                <h5 class="card-title">Revenue Impact</h5>
                <h3 class="text-success">+$2,350</h3>
                <p class="text-muted">Monthly increase</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Customer Impact</h5>
                <h3 class="text-info">-8.5%</h3>
                <p class="text-muted">Estimated traffic change</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Profit Margin</h5>
                <h3 class="text-warning">+3.2%</h3>
                <p class="text-muted">Net margin improvement</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Scenario Library</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Scenario Name</th>
                        <th>Type</th>
                        <th>Parameters</th>
                        <th>Revenue Impact</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>20% Price Increase</strong></td>
                        <td><span class="badge bg-warning">Pricing</span></td>
                        <td>All menu items +20%</td>
                        <td><span class="text-success">+$2,350</span></td>
                        <td>2024-01-15</td>
                        <td><span class="badge bg-success">Complete</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="runScenario(1)">Run</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="editScenario(1)">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Extended Hours</strong></td>
                        <td><span class="badge bg-info">Operations</span></td>
                        <td>Open until 11 PM</td>
                        <td><span class="text-success">+$1,200</span></td>
                        <td>2024-01-12</td>
                        <td><span class="badge bg-success">Complete</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="runScenario(2)">Run</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="editScenario(2)">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>New Menu Items</strong></td>
                        <td><span class="badge bg-success">Menu</span></td>
                        <td>5 new pasta dishes</td>
                        <td><span class="text-success">+$890</span></td>
                        <td>2024-01-10</td>
                        <td><span class="badge bg-warning">Running</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" disabled>Processing...</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New Scenario Modal -->
<div class="modal fade" id="newScenarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Scenario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scenarioForm">
                    <div class="mb-3">
                        <label for="scenarioName" class="form-label">Scenario Name</label>
                        <input type="text" class="form-control" id="scenarioName" required>
                    </div>
                    <div class="mb-3">
                        <label for="scenarioType" class="form-label">Scenario Type</label>
                        <select class="form-select" id="scenarioType" required>
                            <option value="">Select type</option>
                            <option value="pricing">Pricing Changes</option>
                            <option value="operations">Operations Changes</option>
                            <option value="menu">Menu Changes</option>
                            <option value="staffing">Staffing Changes</option>
                            <option value="marketing">Marketing Campaign</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="scenarioDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="scenarioDescription" rows="3"></textarea>
                    </div>
                    
                    <!-- Dynamic parameters based on type -->
                    <div id="scenarioParameters">
                        <h6>Parameters</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parameter1" class="form-label">Parameter 1</label>
                                    <input type="text" class="form-control" id="parameter1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parameter2" class="form-label">Parameter 2</label>
                                    <input type="text" class="form-control" id="parameter2">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createScenario()">Create & Run</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize scenario comparison chart
const ctx = document.getElementById('scenarioChart').getContext('2d');
const scenarioChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Current', '20% Price Increase', 'Extended Hours', 'New Menu Items'],
        datasets: [{
            label: 'Monthly Revenue',
            data: [18500, 20850, 19700, 19390],
            backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)'],
            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

function createScenario() {
    alert('Scenario created and analysis started! Results will be available in a few minutes.');
    $('#newScenarioModal').modal('hide');
    document.getElementById('scenarioForm').reset();
}

function runScenario(id) {
    alert(`Running scenario ${id}... Analysis will complete in a few minutes.`);
}

function viewScenario(id) {
    alert(`Viewing detailed results for scenario ${id}`);
}

function editScenario(id) {
    alert(`Opening scenario ${id} for editing`);
}
</script>
@endpush