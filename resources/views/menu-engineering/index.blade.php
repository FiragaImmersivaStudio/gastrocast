@extends('layouts.app')

@section('title', 'Menu Engineering')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Menu Engineering</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#analyzeMenuModal">
        <i class="fas fa-calculator me-2"></i>Analyze Menu
    </button>
</div>

<!-- Performance Matrix -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Menu Item Performance Matrix</h5>
            </div>
            <div class="card-body">
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="text-success">STARS</h6>
                            <small class="text-muted">High Profit | High Popularity</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="text-info">PLOWHORSES</h6>
                        <small class="text-muted">Low Profit | High Popularity</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="border-end pe-3">
                            <!-- Stars quadrant -->
                            <div class="bg-success bg-opacity-10 p-3 rounded mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Margherita Pizza</strong>
                                    <span class="badge bg-success">Star</span>
                                </div>
                                <small>Profit: $8.50 | Sales: 180 units</small>
                            </div>
                            
                            <div class="bg-success bg-opacity-10 p-3 rounded mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Grilled Salmon</strong>
                                    <span class="badge bg-success">Star</span>
                                </div>
                                <small>Profit: $12.30 | Sales: 98 units</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ps-3">
                            <!-- Plowhorses quadrant -->
                            <div class="bg-info bg-opacity-10 p-3 rounded mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Caesar Salad</strong>
                                    <span class="badge bg-info">Plowhorse</span>
                                </div>
                                <small>Profit: $3.20 | Sales: 145 units</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="text-warning">PUZZLES</h6>
                            <small class="text-muted">High Profit | Low Popularity</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="text-danger">DOGS</h6>
                        <small class="text-muted">Low Profit | Low Popularity</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="border-end pe-3">
                            <!-- Puzzles quadrant -->
                            <div class="bg-warning bg-opacity-10 p-3 rounded mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Lobster Thermidor</strong>
                                    <span class="badge bg-warning">Puzzle</span>
                                </div>
                                <small>Profit: $18.50 | Sales: 12 units</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ps-3">
                            <!-- Dogs quadrant -->
                            <div class="bg-danger bg-opacity-10 p-3 rounded mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Veggie Wrap</strong>
                                    <span class="badge bg-danger">Dog</span>
                                </div>
                                <small>Profit: $2.10 | Sales: 8 units</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recommendations -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">AI Recommendations</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-star me-2"></i>
                    <strong>Promote Stars:</strong> Feature Margherita Pizza and Grilled Salmon prominently in your menu.
                </div>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-puzzle-piece me-2"></i>
                    <strong>Solve Puzzles:</strong> Reduce price or improve promotion for Lobster Thermidor.
                </div>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-horse me-2"></i>
                    <strong>Optimize Plowhorses:</strong> Reduce costs for Caesar Salad to increase profit margin.
                </div>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-times me-2"></i>
                    <strong>Consider Removing Dogs:</strong> Veggie Wrap should be replaced or significantly improved.
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Menu Performance Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h3 class="text-success">2</h3>
                        <small class="text-muted">Stars</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h3 class="text-info">1</h3>
                        <small class="text-muted">Plowhorses</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-warning">1</h3>
                        <small class="text-muted">Puzzles</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-danger">1</h3>
                        <small class="text-muted">Dogs</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">$7.90</h4>
                        <small class="text-muted">Avg Profit per Item</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-primary">68%</h4>
                        <small class="text-muted">Menu Efficiency</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Analysis Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detailed Menu Analysis</h5>
        <button class="btn btn-outline-success btn-sm">
            <i class="fas fa-download me-1"></i>Export Data
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Units Sold</th>
                        <th>Revenue</th>
                        <th>Cost</th>
                        <th>Profit</th>
                        <th>Margin %</th>
                        <th>Classification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Margherita Pizza</strong></td>
                        <td><span class="badge bg-warning">Main</span></td>
                        <td>180</td>
                        <td>$2,700</td>
                        <td>$1,170</td>
                        <td>$1,530</td>
                        <td>56.7%</td>
                        <td><span class="badge bg-success">Star</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Promote</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Caesar Salad</strong></td>
                        <td><span class="badge bg-success">Appetizer</span></td>
                        <td>145</td>
                        <td>$1,885</td>
                        <td>$1,421</td>
                        <td>$464</td>
                        <td>24.6%</td>
                        <td><span class="badge bg-info">Plowhorse</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning">Optimize</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Grilled Salmon</strong></td>
                        <td><span class="badge bg-warning">Main</span></td>
                        <td>98</td>
                        <td>$2,450</td>
                        <td>$1,244</td>
                        <td>$1,206</td>
                        <td>49.2%</td>
                        <td><span class="badge bg-success">Star</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Promote</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Lobster Thermidor</strong></td>
                        <td><span class="badge bg-danger">Premium</span></td>
                        <td>12</td>
                        <td>$480</td>
                        <td>$258</td>
                        <td>$222</td>
                        <td>46.3%</td>
                        <td><span class="badge bg-warning">Puzzle</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info">Promote</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Veggie Wrap</strong></td>
                        <td><span class="badge bg-success">Healthy</span></td>
                        <td>8</td>
                        <td>$96</td>
                        <td>$79.20</td>
                        <td>$16.80</td>
                        <td>17.5%</td>
                        <td><span class="badge bg-danger">Dog</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Analyze Menu Modal -->
<div class="modal fade" id="analyzeMenuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Analyze Menu Performance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="analyzeForm">
                    <div class="mb-3">
                        <label for="analysisPeriod" class="form-label">Analysis Period</label>
                        <select class="form-select" id="analysisPeriod" required>
                            <option value="7d">Last 7 days</option>
                            <option value="30d" selected>Last 30 days</option>
                            <option value="90d">Last 90 days</option>
                            <option value="custom">Custom range</option>
                        </select>
                    </div>
                    <div class="mb-3" id="customRange" style="display: none;">
                        <div class="row">
                            <div class="col-6">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="col-6">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Include Categories</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="appetizers" checked>
                            <label class="form-check-label" for="appetizers">Appetizers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mains" checked>
                            <label class="form-check-label" for="mains">Main Courses</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="desserts" checked>
                            <label class="form-check-label" for="desserts">Desserts</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="beverages" checked>
                            <label class="form-check-label" for="beverages">Beverages</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="runAnalysis()">Run Analysis</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('analysisPeriod').addEventListener('change', function() {
    const customRange = document.getElementById('customRange');
    if (this.value === 'custom') {
        customRange.style.display = 'block';
    } else {
        customRange.style.display = 'none';
    }
});

function runAnalysis() {
    alert('Running menu analysis... Results will be updated shortly.');
    $('#analyzeMenuModal').modal('hide');
}
</script>
@endpush