@extends('layouts.app')

@section('title', 'Promotions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h1>Promotions & Marketing</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPromotionModal">
        <i class="fas fa-plus me-2"></i>Create Promotion
    </button>
</div>

<!-- Active Promotions -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Happy Hour Special</h6>
            </div>
            <div class="card-body">
                <p class="card-text">25% off all drinks from 4-6 PM</p>
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted">Used Today</small>
                        <h5 class="text-success">23</h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Revenue</small>
                        <h5 class="text-success">$345</h5>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <span class="badge bg-success">Active</span>
                    <small class="text-muted ms-2">Ends: Jan 31, 2024</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">Family Combo</h6>
            </div>
            <div class="card-body">
                <p class="card-text">2 mains + 2 sides + drinks for $39.99</p>
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted">Used Today</small>
                        <h5 class="text-info">12</h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Revenue</small>
                        <h5 class="text-info">$479</h5>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <span class="badge bg-info">Active</span>
                    <small class="text-muted ms-2">Ends: Feb 15, 2024</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">Student Discount</h6>
            </div>
            <div class="card-body">
                <p class="card-text">15% off with valid student ID</p>
                <div class="row text-center">
                    <div class="col-6">
                        <small class="text-muted">Used Today</small>
                        <h5 class="text-warning">8</h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Revenue</small>
                        <h5 class="text-warning">$127</h5>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <span class="badge bg-warning text-dark">Active</span>
                    <small class="text-muted ms-2">Ongoing</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Analytics -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Promotion Performance - Last 30 Days</h5>
            </div>
            <div class="card-body">
                <canvas id="promotionChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Top Performing</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Happy Hour</strong>
                            <br><small class="text-muted">689 uses</small>
                        </div>
                        <span class="badge bg-success">+$12,450</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Family Combo</strong>
                            <br><small class="text-muted">287 uses</small>
                        </div>
                        <span class="badge bg-info">+$11,480</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Weekend Special</strong>
                            <br><small class="text-muted">156 uses</small>
                        </div>
                        <span class="badge bg-warning">+$4,680</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All Promotions Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Promotions</h5>
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="promoFilter" id="allPromos" autocomplete="off" checked>
            <label class="btn btn-outline-secondary btn-sm" for="allPromos">All</label>
            
            <input type="radio" class="btn-check" name="promoFilter" id="activePromos" autocomplete="off">
            <label class="btn btn-outline-secondary btn-sm" for="activePromos">Active</label>
            
            <input type="radio" class="btn-check" name="promoFilter" id="scheduledPromos" autocomplete="off">
            <label class="btn btn-outline-secondary btn-sm" for="scheduledPromos">Scheduled</label>
            
            <input type="radio" class="btn-check" name="promoFilter" id="endedPromos" autocomplete="off">
            <label class="btn btn-outline-secondary btn-sm" for="endedPromos">Ended</label>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Promotion Name</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Uses</th>
                        <th>Revenue Impact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Happy Hour Special</strong></td>
                        <td><span class="badge bg-info">Time-based</span></td>
                        <td>25%</td>
                        <td>Jan 1, 2024</td>
                        <td>Jan 31, 2024</td>
                        <td>689</td>
                        <td><span class="text-success">+$12,450</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editPromotion(1)">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="pausePromotion(1)">Pause</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Family Combo</strong></td>
                        <td><span class="badge bg-warning">Bundle</span></td>
                        <td>$10 off</td>
                        <td>Dec 15, 2023</td>
                        <td>Feb 15, 2024</td>
                        <td>287</td>
                        <td><span class="text-success">+$11,480</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editPromotion(2)">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="pausePromotion(2)">Pause</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Student Discount</strong></td>
                        <td><span class="badge bg-secondary">Category</span></td>
                        <td>15%</td>
                        <td>Sep 1, 2023</td>
                        <td>-</td>
                        <td>1,245</td>
                        <td><span class="text-warning">-$2,890</span></td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editPromotion(3)">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="pausePromotion(3)">Pause</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Weekend Special</strong></td>
                        <td><span class="badge bg-primary">Item-specific</span></td>
                        <td>20%</td>
                        <td>Jan 6, 2024</td>
                        <td>Jan 28, 2024</td>
                        <td>156</td>
                        <td><span class="text-success">+$4,680</span></td>
                        <td><span class="badge bg-warning">Scheduled</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editPromotion(4)">Edit</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelPromotion(4)">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Holiday Feast</strong></td>
                        <td><span class="badge bg-danger">Limited-time</span></td>
                        <td>30%</td>
                        <td>Dec 20, 2023</td>
                        <td>Jan 2, 2024</td>
                        <td>234</td>
                        <td><span class="text-success">+$8,750</span></td>
                        <td><span class="badge bg-secondary">Ended</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" onclick="viewAnalytics(5)">Analytics</button>
                            <button class="btn btn-sm btn-outline-success" onclick="duplicatePromotion(5)">Duplicate</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Promotion Modal -->
<div class="modal fade" id="createPromotionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="promotionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="promoName" class="form-label">Promotion Name</label>
                                <input type="text" class="form-control" id="promoName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="promoType" class="form-label">Type</label>
                                <select class="form-select" id="promoType" required>
                                    <option value="">Select type</option>
                                    <option value="percentage">Percentage Discount</option>
                                    <option value="fixed">Fixed Amount Off</option>
                                    <option value="bundle">Bundle Deal</option>
                                    <option value="bogo">Buy One Get One</option>
                                    <option value="category">Category Discount</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discountValue" class="form-label">Discount Value</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discountValue" required>
                                    <span class="input-group-text" id="discountUnit">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="minOrder" class="form-label">Minimum Order (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="minOrder" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" id="startDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date (Optional)</label>
                                <input type="datetime-local" class="form-control" id="endDate">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="applicableItems" class="form-label">Applicable Items</label>
                        <select class="form-select" id="applicableItems" multiple size="4">
                            <option value="all" selected>All Items</option>
                            <option value="appetizers">Appetizers</option>
                            <option value="mains">Main Courses</option>
                            <option value="desserts">Desserts</option>
                            <option value="beverages">Beverages</option>
                        </select>
                        <div class="form-text">Hold Ctrl/Cmd to select multiple items</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="promoDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="promoDescription" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stackable">
                                <label class="form-check-label" for="stackable">
                                    Stackable with other promotions
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoApply">
                                <label class="form-check-label" for="autoApply">
                                    Auto-apply (no code required)
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success me-2" onclick="createAndSchedule()">Create & Schedule</button>
                <button type="button" class="btn btn-primary" onclick="createPromotion()">Create Now</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Promotion Performance Chart
const ctx = document.getElementById('promotionChart').getContext('2d');
const promotionChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Happy Hour', 'Family Combo', 'Student Discount', 'Weekend Special', 'Holiday Feast'],
        datasets: [{
            label: 'Revenue Impact ($)',
            data: [12450, 11480, -2890, 4680, 8750],
            backgroundColor: function(context) {
                const value = context.parsed.y;
                return value >= 0 ? 'rgba(75, 192, 192, 0.8)' : 'rgba(255, 99, 132, 0.8)';
            },
            borderColor: function(context) {
                const value = context.parsed.y;
                return value >= 0 ? 'rgb(75, 192, 192)' : 'rgb(255, 99, 132)';
            },
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
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Update discount unit based on promotion type
document.getElementById('promoType').addEventListener('change', function() {
    const unit = document.getElementById('discountUnit');
    if (this.value === 'percentage') {
        unit.textContent = '%';
    } else {
        unit.textContent = '$';
    }
});

function createPromotion() {
    alert('Promotion created and activated successfully!');
    $('#createPromotionModal').modal('hide');
    document.getElementById('promotionForm').reset();
}

function createAndSchedule() {
    alert('Promotion created and scheduled successfully!');
    $('#createPromotionModal').modal('hide');
    document.getElementById('promotionForm').reset();
}

function editPromotion(id) {
    alert(`Editing promotion ${id}`);
}

function pausePromotion(id) {
    alert(`Promotion ${id} paused`);
}

function cancelPromotion(id) {
    if (confirm('Are you sure you want to cancel this promotion?')) {
        alert(`Promotion ${id} cancelled`);
    }
}

function viewAnalytics(id) {
    alert(`Viewing analytics for promotion ${id}`);
}

function duplicatePromotion(id) {
    alert(`Duplicating promotion ${id}`);
}
</script>
@endpush