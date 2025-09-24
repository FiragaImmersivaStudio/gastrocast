@extends('layouts.app')

@section('title', 'Staffing Planner - GastroCast')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Staffing Planner</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
        <i class="fas fa-calendar-plus me-2"></i>Create Schedule
    </button>
</div>

<!-- Current Week Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Total Staff</h5>
                <h3 class="text-primary">24</h3>
                <p class="text-muted">Active employees</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-2x text-success mb-2"></i>
                <h5 class="card-title">Hours Scheduled</h5>
                <h3 class="text-success">312</h3>
                <p class="text-muted">This week</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Labor Cost</h5>
                <h3 class="text-warning">$4,680</h3>
                <p class="text-muted">Weekly projection</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-percentage fa-2x text-info mb-2"></i>
                <h5 class="card-title">Labor %</h5>
                <h3 class="text-info">28.5%</h3>
                <p class="text-muted">Of revenue</p>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Schedule -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Weekly Schedule</h5>
        <div>
            <button class="btn btn-sm btn-outline-secondary">Previous Week</button>
            <span class="mx-2">Jan 15-21, 2024</span>
            <button class="btn btn-sm btn-outline-secondary">Next Week</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                        <th>Sun</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Mike Johnson</strong><br><small class="text-muted">Head Chef</small></td>
                        <td class="table-success">9-5</td>
                        <td class="table-success">9-5</td>
                        <td class="bg-light">OFF</td>
                        <td class="table-success">9-5</td>
                        <td class="table-success">9-5</td>
                        <td class="table-warning">12-8</td>
                        <td class="bg-light">OFF</td>
                        <td><strong>40h</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Sarah Davis</strong><br><small class="text-muted">Server</small></td>
                        <td class="table-info">5-11</td>
                        <td class="table-info">5-11</td>
                        <td class="table-info">5-11</td>
                        <td class="bg-light">OFF</td>
                        <td class="table-info">5-11</td>
                        <td class="table-info">5-11</td>
                        <td class="table-info">12-6</td>
                        <td><strong>42h</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Tom Wilson</strong><br><small class="text-muted">Prep Cook</small></td>
                        <td class="table-success">7-3</td>
                        <td class="table-success">7-3</td>
                        <td class="table-success">7-3</td>
                        <td class="table-success">7-3</td>
                        <td class="bg-light">OFF</td>
                        <td class="table-success">7-3</td>
                        <td class="bg-light">OFF</td>
                        <td><strong>40h</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Lisa Chen</strong><br><small class="text-muted">Bartender</small></td>
                        <td class="bg-light">OFF</td>
                        <td class="table-warning">6-12</td>
                        <td class="table-warning">6-12</td>
                        <td class="table-warning">6-12</td>
                        <td class="table-warning">6-12</td>
                        <td class="table-warning">6-12</td>
                        <td class="table-warning">3-9</td>
                        <td><strong>42h</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Staffing Analytics -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Staffing vs Demand Forecast</h5>
            </div>
            <div class="card-body">
                <canvas id="staffingChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Staff Availability</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Available Today</span>
                        <strong>18/24</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>On Leave</span>
                        <strong>2/24</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 8%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Called In Sick</span>
                        <strong>1/24</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 4%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Part-time Available</span>
                        <strong>3/24</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 13%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Staff Directory -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Staff Directory</h5>
        <button class="btn btn-outline-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Employee
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Hire Date</th>
                        <th>Hourly Rate</th>
                        <th>This Week</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary me-2">MJ</div>
                                <strong>Mike Johnson</strong>
                            </div>
                        </td>
                        <td>Head Chef</td>
                        <td>2022-03-15</td>
                        <td>$25.00</td>
                        <td>40 hours</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                            <button class="btn btn-sm btn-outline-info">Schedule</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-info me-2">SD</div>
                                <strong>Sarah Davis</strong>
                            </div>
                        </td>
                        <td>Server</td>
                        <td>2023-01-10</td>
                        <td>$15.00</td>
                        <td>42 hours</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                            <button class="btn btn-sm btn-outline-info">Schedule</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-warning me-2">TW</div>
                                <strong>Tom Wilson</strong>
                            </div>
                        </td>
                        <td>Prep Cook</td>
                        <td>2023-06-20</td>
                        <td>$18.00</td>
                        <td>40 hours</td>
                        <td><span class="badge bg-warning">On Leave</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                            <button class="btn btn-sm btn-outline-info">Schedule</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-success me-2">LC</div>
                                <strong>Lisa Chen</strong>
                            </div>
                        </td>
                        <td>Bartender</td>
                        <td>2022-11-05</td>
                        <td>$20.00</td>
                        <td>42 hours</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                            <button class="btn btn-sm btn-outline-info">Schedule</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee" class="form-label">Employee</label>
                                <select class="form-select" id="employee" required>
                                    <option value="">Select employee</option>
                                    <option value="1">Mike Johnson</option>
                                    <option value="2">Sarah Davis</option>
                                    <option value="3">Tom Wilson</option>
                                    <option value="4">Lisa Chen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="scheduleDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="scheduleDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startTime" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="startTime" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endTime" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="endTime" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createSchedule()">Create Schedule</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Staffing Chart
const ctx = document.getElementById('staffingChart').getContext('2d');
const staffingChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Staff Scheduled',
            data: [12, 14, 10, 13, 16, 18, 15],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4
        }, {
            label: 'Demand Forecast',
            data: [10, 15, 9, 14, 17, 20, 16],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderDash: [5, 5],
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Staff'
                }
            }
        }
    }
});

function createSchedule() {
    alert('Schedule created successfully!');
    $('#scheduleModal').modal('hide');
    document.getElementById('scheduleForm').reset();
}
</script>

<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 12px;
}
</style>
@endpush