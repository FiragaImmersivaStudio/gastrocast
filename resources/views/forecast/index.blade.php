@extends('layouts.app')

@section('title', 'Forecast & Insights')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Forecast & Insights</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#runForecastModal">
        <i class="fas fa-chart-line me-2"></i>Run New Forecast
    </button>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-arrow-up fa-2x text-success mb-2"></i>
                <h5 class="card-title">Next 7 Days</h5>
                <h3 class="text-success">+12.5%</h3>
                <p class="text-muted">Sales Growth</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Peak Hour</h5>
                <h3 class="text-info">7:00 PM</h3>
                <p class="text-muted">Expected: 52 customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Weekly Revenue</h5>
                <h3 class="text-warning">$18,500</h3>
                <p class="text-muted">Predicted</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-percentage fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Accuracy</h5>
                <h3 class="text-primary">87.5%</h3>
                <p class="text-muted">Last forecast</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sales Forecast - Next 14 Days</h5>
            </div>
            <div class="card-body">
                <canvas id="forecastChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Peak Hours Heatmap</h5>
            </div>
            <div class="card-body">
                <div class="heatmap-container">
                    <small class="text-muted">Hours vs Days</small>
                    <div class="mt-2">
                        <!-- Simplified heatmap representation -->
                        <div class="row no-gutters text-center">
                            <div class="col"><small>Mon</small></div>
                            <div class="col"><small>Tue</small></div>
                            <div class="col"><small>Wed</small></div>
                            <div class="col"><small>Thu</small></div>
                            <div class="col"><small>Fri</small></div>
                            <div class="col"><small>Sat</small></div>
                            <div class="col"><small>Sun</small></div>
                        </div>
                        <div class="heatmap-grid mt-2">
                            @for($hour = 6; $hour <= 23; $hour++)
                                <div class="row no-gutters mb-1">
                                    <div class="col-auto pe-2"><small>{{ $hour }}:00</small></div>
                                    @for($day = 1; $day <= 7; $day++)
                                        @php
                                            $intensity = rand(0, 3);
                                            $classes = ['bg-light', 'bg-warning bg-opacity-25', 'bg-warning bg-opacity-50', 'bg-danger bg-opacity-75'];
                                        @endphp
                                        <div class="col">
                                            <div class="heatmap-cell {{ $classes[$intensity] }}" style="height: 15px; border: 1px solid #eee;"></div>
                                        </div>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Forecasts -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Recent Forecasts</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Run Date</th>
                        <th>Period</th>
                        <th>Type</th>
                        <th>Accuracy</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15 14:30</td>
                        <td>Jan 16-30, 2024</td>
                        <td>Sales & Traffic</td>
                        <td><span class="badge bg-success">89.2%</span></td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">View Report</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-10 10:15</td>
                        <td>Jan 11-25, 2024</td>
                        <td>Peak Hours</td>
                        <td><span class="badge bg-success">85.7%</span></td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">View Report</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-08 16:45</td>
                        <td>Jan 9-23, 2024</td>
                        <td>Revenue</td>
                        <td><span class="badge bg-warning">76.3%</span></td>
                        <td><span class="badge bg-success">Completed</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">View Report</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Run Forecast Modal -->
<div class="modal fade" id="runForecastModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Run New Forecast</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="forecastForm">
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
                        <label class="form-label">Forecast Metrics</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sales" checked>
                            <label class="form-check-label" for="sales">Sales Revenue</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="customerCount" checked>
                            <label class="form-check-label" for="customerCount">Customer Count</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="avgOrderValue">
                            <label class="form-check-label" for="avgOrderValue">Average Order Value</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="peakHours">
                            <label class="form-check-label" for="peakHours">Peak Hours Analysis</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="runForecast()">Run Forecast</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize forecast chart
const ctx = document.getElementById('forecastChart').getContext('2d');
const forecastChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan 16', 'Jan 17', 'Jan 18', 'Jan 19', 'Jan 20', 'Jan 21', 'Jan 22', 'Jan 23', 'Jan 24', 'Jan 25', 'Jan 26', 'Jan 27', 'Jan 28', 'Jan 29'],
        datasets: [{
            label: 'Predicted Sales',
            data: [2500, 2800, 2650, 2900, 3200, 3800, 3600, 2400, 2700, 2950, 3100, 3400, 3900, 3700],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4
        }, {
            label: 'Historical Average',
            data: [2200, 2300, 2400, 2500, 2600, 3000, 2900, 2100, 2200, 2400, 2500, 2700, 3100, 2900],
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
                beginAtZero: false,
                ticks: {
                    callback: function(value) {
                        return '$' + value;
                    }
                }
            }
        }
    }
});

function runForecast() {
    // Simulate forecast run
    alert('Forecast analysis started! This may take a few minutes. You will be notified when it completes.');
    $('#runForecastModal').modal('hide');
    document.getElementById('forecastForm').reset();
}
</script>
@endpush