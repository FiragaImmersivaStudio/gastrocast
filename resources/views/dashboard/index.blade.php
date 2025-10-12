@extends('layouts.app')

@section('content')
<div class="py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>
                Overview Dashboard
            </h1>
            <p class="text-muted mb-0">Real-time insights and analytics for your restaurant operations</p>
        </div>
        <div>
            <button class="btn btn-primary me-2" onclick="generateForecast()">
                <i class="fas fa-chart-line me-1"></i>Generate Forecast
            </button>
            <button class="btn btn-warning" onclick="exportReport()">
                <i class="fas fa-file-pdf me-1"></i>Export PDF
            </button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">Visitors</div>
                            <div class="h4 mb-0" id="kpi-visitors">1,247</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">Transactions</div>
                            <div class="h4 mb-0" id="kpi-transactions">892</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up"></i> 8.3%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">GMV</div>
                            <div class="h4 mb-0" id="kpi-gmv">$18,542</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up"></i> 15.7%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-percentage fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">Conversion Rate</div>
                            <div class="h4 mb-0" id="kpi-conversion">71.5%</div>
                            <div class="small text-danger">
                                <i class="fas fa-arrow-down"></i> 2.1%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-receipt fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">AOV</div>
                            <div class="h4 mb-0" id="kpi-aov">$20.79</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-up"></i> 6.8%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bullseye fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted">MAPE</div>
                            <div class="h4 mb-0" id="kpi-mape">8.2%</div>
                            <div class="small text-success">
                                <i class="fas fa-arrow-down"></i> 1.3%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Forecast Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Revenue Forecast (Next 14 Days)
                    </h5>
                </div>
                <div class="card-body">
                    <div id="forecast-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- AI Summary -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-robot text-primary me-2"></i>
                        AI Insights
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">Executive Summary</h6>
                        <p class="small text-muted" id="ai-summary">
                            Performance minggu ini menunjukkan tren positif dengan peningkatan traffic 12.5% dan GMV naik 15.7%. 
                            Conversion rate turun 2.1% menunjukkan adanya opportunity untuk optimasi menu dan pricing. 
                            Weekend traffic pattern stabil dengan peak hours 12:00-14:00 dan 18:00-20:00.
                        </p>
                    </div>
                    
                    <div>
                        <h6 class="text-primary">Action Items</h6>
                        <ul class="small text-muted mb-0" id="ai-actions">
                            <li>Tambah 1 kasir pada jam peak 18:30-20:30</li>
                            <li>Review menu pricing untuk items low-conversion</li>
                            <li>Stock tambahan beef patty +15% untuk weekend</li>
                            <li>Aktifkan promo combo untuk meningkatkan AOV</li>
                        </ul>
                    </div>
                    
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-primary" onclick="refreshAISummary()">
                            <i class="fas fa-sync me-1"></i>Refresh Summary
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Traffic Heatmap -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-fire text-primary me-2"></i>
                        Traffic Heatmap (Hour × Day)
                    </h5>
                </div>
                <div class="card-body">
                    <div id="heatmap-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Top Menu Items -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-medal text-primary me-2"></i>
                        Top Performing Menu Items
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Sales</th>
                                    <th>Revenue</th>
                                    <th>Margin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Classic Beef Burger</strong></td>
                                    <td>147</td>
                                    <td>$2,344</td>
                                    <td><span class="badge bg-success">46.7%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Cheese Deluxe</strong></td>
                                    <td>112</td>
                                    <td>$2,010</td>
                                    <td><span class="badge bg-success">48.4%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>French Fries</strong></td>
                                    <td>203</td>
                                    <td>$1,208</td>
                                    <td><span class="badge bg-success">58.0%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>BBQ Bacon Burger</strong></td>
                                    <td>89</td>
                                    <td>$1,776</td>
                                    <td><span class="badge bg-warning">46.1%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Soft Drink</strong></td>
                                    <td>256</td>
                                    <td>$755</td>
                                    <td><span class="badge bg-success">74.6%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    initializeForecastChart();
    initializeHeatmapChart();
    loadCachedSummary();
});

// Load cached summary on page load
function loadCachedSummary() {
    const restaurantId = getSelectedRestaurantId();
    
    fetch('/api/llm/summary?' + new URLSearchParams({
        context: 'overview',
        restaurant_id: restaurantId || ''
    }), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.data) {
            document.getElementById('ai-summary').innerHTML = data.data.response;
            
            if (data.data.action_items && data.data.action_items.length > 0) {
                const actionItemsHtml = data.data.action_items.map(item => `<li>${item}</li>`).join('');
                document.getElementById('ai-actions').innerHTML = actionItemsHtml;
            }
        }
    })
    .catch(error => {
        console.log('No cached summary available, using default content');
    });
}

// Get selected restaurant ID from session or dropdown
function getSelectedRestaurantId() {
    // Try to get from session storage first
    const sessionRestaurantId = sessionStorage.getItem('selected_restaurant_id');
    if (sessionRestaurantId) {
        return sessionRestaurantId;
    }
    
    // Try to get from server session via AJAX if needed
    return null; // Will use server session in the controller
}

// Forecast Chart with Confidence Intervals
function initializeForecastChart() {
    // Sample data - in real app this would come from API
    const historicalData = [
        [Date.UTC(2024, 8, 1), 850], [Date.UTC(2024, 8, 2), 920], [Date.UTC(2024, 8, 3), 780],
        [Date.UTC(2024, 8, 4), 1150], [Date.UTC(2024, 8, 5), 1280], [Date.UTC(2024, 8, 6), 1320],
        [Date.UTC(2024, 8, 7), 1200], [Date.UTC(2024, 8, 8), 890], [Date.UTC(2024, 8, 9), 940],
        [Date.UTC(2024, 8, 10), 810], [Date.UTC(2024, 8, 11), 1180], [Date.UTC(2024, 8, 12), 1350],
        [Date.UTC(2024, 8, 13), 1420], [Date.UTC(2024, 8, 14), 1250]
    ];
    
    const forecastData = [
        [Date.UTC(2024, 8, 15), 1100], [Date.UTC(2024, 8, 16), 1180], [Date.UTC(2024, 8, 17), 950],
        [Date.UTC(2024, 8, 18), 1220], [Date.UTC(2024, 8, 19), 1380], [Date.UTC(2024, 8, 20), 1450],
        [Date.UTC(2024, 8, 21), 1350], [Date.UTC(2024, 8, 22), 1150], [Date.UTC(2024, 8, 23), 1220],
        [Date.UTC(2024, 8, 24), 1050], [Date.UTC(2024, 8, 25), 1280], [Date.UTC(2024, 8, 26), 1410],
        [Date.UTC(2024, 8, 27), 1480], [Date.UTC(2024, 8, 28), 1380]
    ];

    Highcharts.chart('forecast-chart', {
        chart: {
            type: 'line',
            backgroundColor: 'transparent'
        },
        title: {
            text: null
        },
        xAxis: {
            type: 'datetime',
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'Revenue ($)'
            }
        },
        tooltip: {
            shared: true,
            valuePrefix: '$'
        },
        plotOptions: {
            area: {
                fillOpacity: 0.1
            }
        },
        series: [{
            name: 'Historical Revenue',
            data: historicalData,
            color: '#7A001F',
            zIndex: 2
        }, {
            name: 'Forecasted Revenue',
            data: forecastData,
            color: '#FF6B6B',
            dashStyle: 'dash',
            zIndex: 2
        }, {
            name: '95% Confidence Interval',
            data: forecastData.map(point => [point[0], point[1] * 1.2]),
            type: 'area',
            color: '#7A001F',
            fillOpacity: 0.1,
            lineWidth: 0,
            marker: {
                enabled: false
            },
            enableMouseTracking: false,
            zIndex: 0
        }, {
            name: '95% Confidence Interval Lower',
            data: forecastData.map(point => [point[0], point[1] * 0.8]),
            type: 'area',
            color: '#7A001F',
            fillOpacity: 0.1,
            lineWidth: 0,
            marker: {
                enabled: false
            },
            enableMouseTracking: false,
            zIndex: 1
        }],
        legend: {
            enabled: true
        },
        credits: {
            enabled: false
        }
    });
}

// Traffic Heatmap Chart
function initializeHeatmapChart() {
    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const hours = Array.from({length: 12}, (_, i) => `${i + 11}:00`);
    
    // Generate sample heatmap data
    const data = [];
    for (let day = 0; day < 7; day++) {
        for (let hour = 0; hour < 12; hour++) {
            const value = Math.floor(Math.random() * 100) + 20;
            data.push([hour, day, value]);
        }
    }

    Highcharts.chart('heatmap-chart', {
        chart: {
            type: 'heatmap',
            backgroundColor: 'transparent'
        },
        title: {
            text: null
        },
        xAxis: {
            categories: hours,
            title: {
                text: 'Hour'
            }
        },
        yAxis: {
            categories: days,
            title: {
                text: 'Day'
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: '#7A001F'
        },
        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top'
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.yAxis.categories[this.point.y] + '</b> at <b>' + 
                       this.series.xAxis.categories[this.point.x] + '</b><br><b>' + 
                       this.point.value + '</b> visitors';
            }
        },
        series: [{
            name: 'Traffic',
            borderWidth: 1,
            data: data,
            dataLabels: {
                enabled: false
            }
        }],
        credits: {
            enabled: false
        }
    });
}

// Action Functions
function generateForecast() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert('Forecast generated successfully! New data will be reflected in the charts.');
        btn.innerHTML = originalText;
        btn.disabled = false;
        // In real app, this would refresh the chart data
    }, 2000);
}

function exportReport() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating PDF...';
    btn.disabled = true;
    
    // Simulate PDF generation
    setTimeout(() => {
        alert('PDF report generated! Check your downloads folder.');
        btn.innerHTML = originalText; 
        btn.disabled = false;
        // In real app, this would trigger PDF download
    }, 3000);
}

function refreshAISummary() {
    const summaryEl = document.getElementById('ai-summary');
    const actionsEl = document.getElementById('ai-actions');
    const btn = event.target;
    
    // Show loading state
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Refreshing...';
    btn.disabled = true;
    
    // Get current restaurant selection
    const restaurantId = getSelectedRestaurantId();
    
    // Make API call to generate new summary
    fetch('/api/llm/summary', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            context: 'overview',
            restaurant_id: restaurantId,
            force_refresh: true
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.data) {
            summaryEl.innerHTML = data.data.response;
            
            // Update action items
            if (data.data.action_items && data.data.action_items.length > 0) {
                const actionItemsHtml = data.data.action_items.map(item => `<li>${item}</li>`).join('');
                actionsEl.innerHTML = actionItemsHtml;
            }
            
            // Show cache status
            if (data.data.cached) {
                btn.title = 'Using cached result from ' + new Date(data.data.generated_at).toLocaleString();
            } else {
                btn.title = 'Generated at ' + new Date(data.data.generated_at).toLocaleString();
            }
        } else {
            alert('Failed to refresh summary: ' + (data.message || 'Unknown error'));
        }
        
        btn.innerHTML = '<i class="fas fa-sync me-1"></i>Refresh Summary ';
        btn.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to refresh summary. Please try again.');
        btn.innerHTML = '<i class="fas fa-sync me-1"></i>Refresh Summary';
        btn.disabled = false;
    });
}

// Auto-refresh KPIs every 30 seconds
setInterval(function() {
    // Simulate real-time KPI updates
    document.getElementById('kpi-visitors').textContent = (1200 + Math.floor(Math.random() * 100)).toLocaleString();
    document.getElementById('kpi-transactions').textContent = (850 + Math.floor(Math.random() * 100)).toLocaleString();
    document.getElementById('kpi-gmv').textContent = '$' + (18000 + Math.floor(Math.random() * 2000)).toLocaleString();
}, 30000);
</script>
@endsection