@extends('layouts.app')

@section('title', 'Operations Monitor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h1>Operations Monitor</h1>
    <div>
        <button class="btn btn-outline-secondary me-2">
            <i class="fas fa-sync-alt me-1"></i>Refresh
        </button>
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="viewMode" id="liveView" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="liveView">Live</label>
            
            <input type="radio" class="btn-check" name="viewMode" id="dayView" autocomplete="off">
            <label class="btn btn-outline-primary" for="dayView">Day</label>
            
            <input type="radio" class="btn-check" name="viewMode" id="weekView" autocomplete="off">
            <label class="btn btn-outline-primary" for="weekView">Week</label>
        </div>
    </div>
</div>

<!-- Real-time Status Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-2x text-success mb-2"></i>
                <h5 class="card-title">Current Orders</h5>
                <h3 class="text-success">14</h3>
                <p class="text-muted">In queue</p>
                <div class="progress mt-2">
                    <div class="progress-bar bg-success" style="width: 70%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-info mb-2"></i>
                <h5 class="card-title">Staff On Duty</h5>
                <h3 class="text-info">8</h3>
                <p class="text-muted">Active now</p>
                <small class="text-success"><i class="fas fa-arrow-up"></i> Fully staffed</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-thermometer-half fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Kitchen Temp</h5>
                <h3 class="text-warning">78°F</h3>
                <p class="text-muted">Optimal range</p>
                <small class="text-success"><i class="fas fa-check"></i> Normal</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-tachometer-alt fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Avg Wait Time</h5>
                <h3 class="text-primary">12m</h3>
                <p class="text-muted">Current average</p>
                <small class="text-success"><i class="fas fa-arrow-down"></i> -2min from yesterday</small>
            </div>
        </div>
    </div>
</div>

<!-- Live Order Queue -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Live Order Queue</h5>
                <span class="badge bg-success">Live</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Items</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-warning">
                                <td><strong>#1247</strong></td>
                                <td>2x Margherita, 1x Caesar Salad</td>
                                <td>18:45</td>
                                <td><span class="badge bg-warning">Preparing</span></td>
                                <td><span class="badge bg-danger">High</span></td>
                            </tr>
                            <tr>
                                <td><strong>#1248</strong></td>
                                <td>1x Grilled Salmon, 1x Wine</td>
                                <td>18:47</td>
                                <td><span class="badge bg-info">Cooking</span></td>
                                <td><span class="badge bg-success">Normal</span></td>
                            </tr>
                            <tr>
                                <td><strong>#1249</strong></td>
                                <td>3x Burger, 2x Fries</td>
                                <td>18:50</td>
                                <td><span class="badge bg-secondary">Queue</span></td>
                                <td><span class="badge bg-success">Normal</span></td>
                            </tr>
                            <tr>
                                <td><strong>#1250</strong></td>
                                <td>1x Pasta, 1x Salad</td>
                                <td>18:52</td>
                                <td><span class="badge bg-secondary">Queue</span></td>
                                <td><span class="badge bg-success">Normal</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kitchen Stations</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center p-2 border rounded">
                            <i class="fas fa-fire fa-lg text-danger mb-1"></i>
                            <div><small><strong>Grill</strong></small></div>
                            <div><span class="badge bg-success">Available</span></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-2 border rounded">
                            <i class="fas fa-blender fa-lg text-info mb-1"></i>
                            <div><small><strong>Prep</strong></small></div>
                            <div><span class="badge bg-warning">Busy</span></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center p-2 border rounded">
                            <i class="fas fa-pizza-slice fa-lg text-warning mb-1"></i>
                            <div><small><strong>Pizza Oven</strong></small></div>
                            <div><span class="badge bg-danger">Busy</span></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-2 border rounded">
                            <i class="fas fa-ice-cream fa-lg text-primary mb-1"></i>
                            <div><small><strong>Cold Station</strong></small></div>
                            <div><span class="badge bg-success">Available</span></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center p-2 border rounded">
                            <i class="fas fa-cocktail fa-lg text-success mb-1"></i>
                            <div><small><strong>Bar</strong></small></div>
                            <div><span class="badge bg-success">Available</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Charts -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Volume Today</h5>
            </div>
            <div class="card-body">
                <canvas id="orderVolumeChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Wait Time Trends</h5>
            </div>
            <div class="card-body">
                <canvas id="waitTimeChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Staff Performance -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Staff Performance Today</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Role</th>
                                <th>Orders</th>
                                <th>Efficiency</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Mike Johnson</strong></td>
                                <td>Chef</td>
                                <td>34</td>
                                <td><span class="badge bg-success">95%</span></td>
                                <td><i class="fas fa-circle text-success" title="Active"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Sarah Davis</strong></td>
                                <td>Server</td>
                                <td>18</td>
                                <td><span class="badge bg-success">92%</span></td>
                                <td><i class="fas fa-circle text-success" title="Active"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Tom Wilson</strong></td>
                                <td>Prep Cook</td>
                                <td>28</td>
                                <td><span class="badge bg-warning">78%</span></td>
                                <td><i class="fas fa-circle text-warning" title="Break"></i></td>
                            </tr>
                            <tr>
                                <td><strong>Lisa Chen</strong></td>
                                <td>Bartender</td>
                                <td>22</td>
                                <td><span class="badge bg-success">89%</span></td>
                                <td><i class="fas fa-circle text-success" title="Active"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Alerts</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Inventory Alert:</strong> Tomatoes running low (5 lbs remaining)
                        <br><small class="text-muted">2 minutes ago</small>
                    </div>
                </div>
                
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        <strong>Rush Hour:</strong> Peak time approaching (7:00 PM)
                        <br><small class="text-muted">5 minutes ago</small>
                    </div>
                </div>
                
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Equipment:</strong> All kitchen equipment operating normally
                        <br><small class="text-muted">10 minutes ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Status (for dine-in restaurants) -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Table Status</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @for($table = 1; $table <= 16; $table++)
                @php
                    $statuses = ['available', 'occupied', 'reserved', 'cleaning'];
                    $status = $statuses[array_rand($statuses)];
                    $badgeClass = [
                        'available' => 'bg-success',
                        'occupied' => 'bg-danger', 
                        'reserved' => 'bg-warning',
                        'cleaning' => 'bg-secondary'
                    ][$status];
                @endphp
                <div class="col-md-3 col-sm-4 col-6 mb-3">
                    <div class="card border-{{ substr($badgeClass, 3) }}">
                        <div class="card-body text-center p-2">
                            <h6 class="mb-1">Table {{ $table }}</h6>
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            @if($status === 'occupied')
                                <br><small class="text-muted">Since 18:30</small>
                            @elseif($status === 'reserved')
                                <br><small class="text-muted">19:00 PM</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Order Volume Chart
const orderCtx = document.getElementById('orderVolumeChart').getContext('2d');
const orderChart = new Chart(orderCtx, {
    type: 'line',
    data: {
        labels: ['11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'],
        datasets: [{
            label: 'Orders per Hour',
            data: [5, 12, 18, 8, 6, 9, 15, 22, 14],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Wait Time Chart
const waitCtx = document.getElementById('waitTimeChart').getContext('2d');
const waitChart = new Chart(waitCtx, {
    type: 'line',
    data: {
        labels: ['11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'],
        datasets: [{
            label: 'Average Wait Time (minutes)',
            data: [8, 15, 18, 10, 7, 9, 12, 16, 12],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value + ' min';
                    }
                }
            }
        }
    }
});

// Auto-refresh every 30 seconds in live mode
setInterval(function() {
    if (document.getElementById('liveView').checked) {
        // In a real app, this would fetch fresh data
        console.log('Refreshing live data...');
    }
}, 30000);
</script>
@endsection