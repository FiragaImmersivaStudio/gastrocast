@extends('layouts.app')

@section('title', 'Forecast & Insights')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h1>Forecast & Insights</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#runForecastModal">
        <i class="fas fa-chart-line me-2"></i>Run New Forecast
    </button>
</div>

<!-- AI Summary Card -->
<div class="row mb-4" id="aiSummaryContainer" style="display: none;">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-brain me-2"></i>AI Forecast Summary</h5>
                    <small id="aiModelBadge"></small>
                </div>
            </div>
            <div class="card-body">
                <div id="aiSummaryText" class="forecast-summary-text"></div>
                <div id="aiActionItems" class="mt-3"></div>
                <div class="mt-2 text-muted small" id="aiMetadata"></div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4" id="summaryCards">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                <h5 class="card-title">Predicted Sales</h5>
                <h3 class="text-success" id="totalSales">-</h3>
                <p class="text-muted" id="avgDailySales">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                <h5 class="card-title">Predicted Profit</h5>
                <h3 class="text-info" id="totalProfit">-</h3>
                <p class="text-muted" id="profitMargin">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-warning mb-2"></i>
                <h5 class="card-title">Expected Visitors</h5>
                <h3 class="text-warning" id="totalVisitors">-</h3>
                <p class="text-muted" id="avgDailyVisitors">-</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-percentage fa-2x text-primary mb-2"></i>
                <h5 class="card-title">Forecast Accuracy</h5>
                <h3 class="text-primary" id="accuracy">-</h3>
                <p class="text-muted">Based on historical data</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sales & Visitors Forecast</h5>
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
                <div class="heatmap-container" id="heatmapContainer">
                    <small class="text-muted">Loading...</small>
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
            <table class="table" id="forecastsTable">
                <thead>
                    <tr>
                        <th>Run Date</th>
                        <th>Period</th>
                        <th>Days</th>
                        <th>Accuracy</th>
                        <th>Model</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="forecastsTableBody">
                    <tr>
                        <td colspan="6" class="text-center text-muted">No forecasts yet. Click "Run New Forecast" to generate one.</td>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Maximum forecast period is 90 days. Start date must be in the future.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="startDate" required>
                                <div class="invalid-feedback">Start date must be in the future</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="endDate" required>
                                <div class="invalid-feedback">End date must be after start date and within 90 days</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Forecast Metrics</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sales" checked disabled>
                            <label class="form-check-label" for="sales">Sales Revenue (Required)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="profit" checked disabled>
                            <label class="form-check-label" for="profit">Profit Prediction (Required)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="customerCount" checked disabled>
                            <label class="form-check-label" for="customerCount">Customer Count (Required)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="peakHours" checked disabled>
                            <label class="form-check-label" for="peakHours">Peak Hours Analysis (Required)</label>
                        </div>
                    </div>
                    <div id="forecastError" class="alert alert-danger" style="display: none;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="runForecast()" id="runForecastBtn">
                    <i class="fas fa-play me-2"></i>Run Forecast
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h4 class="mt-3">Generating Forecast...</h4>
        <p>This may take a few moments</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let forecastChart = null;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDateInputs();
    loadRecentForecasts();
    loadForecastSummary();
});

// Initialize date inputs with validation
function initializeDateInputs() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    // Set minimum date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const minDate = tomorrow.toISOString().split('T')[0];
    
    startDateInput.min = minDate;
    endDateInput.min = minDate;
    
    // Set default dates
    const defaultStart = new Date();
    defaultStart.setDate(defaultStart.getDate() + 1);
    const defaultEnd = new Date();
    defaultEnd.setDate(defaultEnd.getDate() + 14);
    
    startDateInput.value = defaultStart.toISOString().split('T')[0];
    endDateInput.value = defaultEnd.toISOString().split('T')[0];
    
    // Add validation on change
    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);
}

// Validate date inputs
function validateDates() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const errorDiv = document.getElementById('forecastError');
    
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    let isValid = true;
    let errorMsg = '';
    
    // Check if start date is in the past
    if (startDate <= today) {
        isValid = false;
        errorMsg = 'Tanggal mulai harus di masa depan (minimal besok)';
        startDateInput.classList.add('is-invalid');
    } else {
        startDateInput.classList.remove('is-invalid');
    }
    
    // Check if end date is after start date
    if (endDate <= startDate) {
        isValid = false;
        errorMsg = 'Tanggal akhir harus setelah tanggal mulai';
        endDateInput.classList.add('is-invalid');
    } else {
        endDateInput.classList.remove('is-invalid');
    }
    
    // Check if period is within 90 days
    const daysDiff = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
    if (daysDiff > 90) {
        isValid = false;
        errorMsg = 'Periode forecast tidak boleh lebih dari 90 hari';
        endDateInput.classList.add('is-invalid');
    }
    
    if (!isValid) {
        errorDiv.textContent = errorMsg;
        errorDiv.style.display = 'block';
    } else {
        errorDiv.style.display = 'none';
    }
    
    return isValid;
}

// Run forecast
async function runForecast() {
    if (!validateDates()) {
        return;
    }
    
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const runBtn = document.getElementById('runForecastBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    runBtn.disabled = true;
    runBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    loadingOverlay.style.display = 'block';
    
    try {
        const response = await fetch('/api/forecast/run', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate,
                metrics: ['sales', 'profit', 'customer_count', 'peak_hours']
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to generate forecast');
        }
        
        // Hide modal
        bootstrap.Modal.getInstance(document.getElementById('runForecastModal')).hide();
        
        // Display forecast results
        displayForecastResults(data.data);
        
        // Reload recent forecasts
        loadRecentForecasts();
        
        // Show success message
        showAlert('success', 'Forecast berhasil dibuat!');
        
    } catch (error) {
        console.error('Forecast error:', error);
        document.getElementById('forecastError').textContent = error.message;
        document.getElementById('forecastError').style.display = 'block';
    } finally {
        runBtn.disabled = false;
        runBtn.innerHTML = '<i class="fas fa-play me-2"></i>Run Forecast';
        loadingOverlay.style.display = 'none';
    }
}

// Display forecast results
function displayForecastResults(data) {
    // Update AI Summary Card
    if (data.ai_summary && data.ai_summary.text) {
        document.getElementById('aiSummaryContainer').style.display = 'block';
        document.getElementById('aiSummaryText').innerHTML = formatText(data.ai_summary.text);
        
        if (data.ai_summary.action_items && data.ai_summary.action_items.length > 0) {
            const actionItemsHtml = '<div class="mt-3"><strong>Action Items:</strong><ul class="mt-2">' +
                data.ai_summary.action_items.map(item => `<li>${item}</li>`).join('') +
                '</ul></div>';
            document.getElementById('aiActionItems').innerHTML = actionItemsHtml;
        }
        
        document.getElementById('aiModelBadge').textContent = data.ai_summary.model_used || 'AI Model';
        document.getElementById('aiMetadata').textContent = 
            `Generated in ${data.processing_time_ms}ms | Tokens: ${data.ai_summary.tokens_used || 0}`;
    }
    
    // Update summary cards
    const metrics = data.summary_metrics;
    document.getElementById('totalSales').textContent = formatCurrency(metrics.total_predicted_sales);
    document.getElementById('avgDailySales').textContent = 'Avg: ' + formatCurrency(metrics.avg_daily_sales) + '/day';
    document.getElementById('totalProfit').textContent = formatCurrency(metrics.total_predicted_profit);
    document.getElementById('profitMargin').textContent = '~22% margin';
    document.getElementById('totalVisitors').textContent = formatNumber(metrics.total_predicted_visitors);
    document.getElementById('avgDailyVisitors').textContent = 'Avg: ' + formatNumber(metrics.avg_daily_visitors) + '/day';
    document.getElementById('accuracy').textContent = metrics.accuracy + '%';
    
    // Update chart
    updateForecastChart(data.daily_predictions);
    
    // Update heatmap
    updateHeatmap(data.peak_hours_heatmap);
}

// Update forecast chart
function updateForecastChart(predictions) {
    const ctx = document.getElementById('forecastChart').getContext('2d');
    
    const labels = predictions.map(p => p.date);
    const salesData = predictions.map(p => p.predicted_sales);
    const visitorsData = predictions.map(p => p.predicted_visitors);
    
    if (forecastChart) {
        forecastChart.destroy();
    }
    
    forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Predicted Sales',
                data: salesData,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            }, {
                label: 'Predicted Visitors',
                data: visitorsData,
                borderColor: 'rgb(255, 159, 64)',
                backgroundColor: 'rgba(255, 159, 64, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.datasetIndex === 0) {
                                    label += formatCurrency(context.parsed.y);
                                } else {
                                    label += formatNumber(context.parsed.y);
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Sales (Rp)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Visitors'
                    },
                    grid: {
                        drawOnChartArea: false,
                    }
                }
            }
        }
    });
}

// Update heatmap
function updateHeatmap(heatmapData) {
    const container = document.getElementById('heatmapContainer');
    
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    const intensityColors = ['#f8f9fa', '#fff3cd', '#ffc107', '#dc3545'];
    
    let html = '<small class="text-muted">Hours vs Days</small><div class="mt-2">';
    html += '<div class="row g-0 text-center mb-2">';
    html += '<div class="col-auto" style="width: 50px;"></div>';
    days.forEach(day => {
        html += `<div class="col"><small>${day}</small></div>`;
    });
    html += '</div>';
    
    heatmapData.forEach(hourData => {
        html += '<div class="row g-0 mb-1">';
        html += `<div class="col-auto pe-2" style="width: 50px;"><small>${hourData.hour_label}</small></div>`;
        
        hourData.days.forEach(dayData => {
            const color = intensityColors[dayData.intensity];
            const visitors = dayData.avg_visitors;
            html += `<div class="col">
                <div class="heatmap-cell" 
                     style="height: 15px; border: 1px solid #eee; background-color: ${color};" 
                     title="${visitors} visitors"></div>
            </div>`;
        });
        
        html += '</div>';
    });
    
    html += '</div>';
    container.innerHTML = html;
}

// Load recent forecasts
async function loadRecentForecasts() {
    try {
        const response = await fetch('/api/forecast', {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) return;
        
        const data = await response.json();
        
        if (data.success && data.data.length > 0) {
            const tbody = document.getElementById('forecastsTableBody');
            tbody.innerHTML = data.data.map(forecast => `
                <tr>
                    <td>${forecast.created_at}</td>
                    <td>${forecast.period.start} - ${forecast.period.end}</td>
                    <td>${forecast.horizon_days} days</td>
                    <td>${forecast.accuracy ? `<span class="badge bg-success">${forecast.accuracy}%</span>` : '<span class="badge bg-secondary">N/A</span>'}</td>
                    <td><span class="badge bg-info">${forecast.model_used || 'N/A'}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="viewForecast(${forecast.id})">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error loading forecasts:', error);
    }
}

// Load forecast summary
async function loadForecastSummary() {
    try {
        const response = await fetch('/api/forecast/summary', {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) return;
        
        const data = await response.json();
        
        if (data.success && data.data.last_forecast) {
            // Could update summary cards with last forecast data if needed
        }
    } catch (error) {
        console.error('Error loading summary:', error);
    }
}

// View specific forecast
async function viewForecast(forecastId) {
    try {
        const response = await fetch(`/api/forecast/${forecastId}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load forecast');
        
        const data = await response.json();
        
        if (data.success) {
            // Build forecast data structure for display
            const forecastData = {
                daily_predictions: data.data.predictions || [],
                summary_metrics: calculateSummaryMetrics(data.data.predictions || []),
                ai_summary: {
                    text: data.data.summary || '',
                    model_used: data.data.model_used || 'N/A'
                },
                processing_time_ms: data.data.processing_time_ms || 0,
                peak_hours_heatmap: [] // Would need to be included in response
            };
            
            displayForecastResults(forecastData);
        }
    } catch (error) {
        console.error('Error viewing forecast:', error);
        showAlert('danger', 'Failed to load forecast details');
    }
}

// Calculate summary metrics from predictions
function calculateSummaryMetrics(predictions) {
    if (!predictions || predictions.length === 0) {
        return {
            total_predicted_sales: 0,
            total_predicted_profit: 0,
            total_predicted_visitors: 0,
            avg_daily_sales: 0,
            avg_daily_visitors: 0,
            accuracy: 85
        };
    }
    
    const totalSales = predictions.reduce((sum, p) => sum + (p.predicted_sales || 0), 0);
    const totalProfit = predictions.reduce((sum, p) => sum + (p.predicted_profit || 0), 0);
    const totalVisitors = predictions.reduce((sum, p) => sum + (p.predicted_visitors || 0), 0);
    
    return {
        total_predicted_sales: totalSales,
        total_predicted_profit: totalProfit,
        total_predicted_visitors: totalVisitors,
        avg_daily_sales: totalSales / predictions.length,
        avg_daily_visitors: totalVisitors / predictions.length,
        accuracy: predictions[0]?.confidence || 85
    };
}

// Utility functions
function formatCurrency(value) {
    return 'Rp ' + Math.round(value).toLocaleString('id-ID');
}

function formatNumber(value) {
    return Math.round(value).toLocaleString('id-ID');
}

function formatText(text) {
    // Convert line breaks to HTML
    return text.replace(/\n/g, '<br>');
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
<style>
.forecast-summary-text {
    line-height: 1.8;
    white-space: pre-wrap;
    font-size: 1rem;
}

.heatmap-cell {
    cursor: pointer;
    transition: transform 0.2s;
}

.heatmap-cell:hover {
    transform: scale(1.1);
    border: 2px solid #000 !important;
}
</style>
@endsection