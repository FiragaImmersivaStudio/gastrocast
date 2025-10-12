@extends('layouts.app')

@section('title', 'Inventory & Waste Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Inventory & Waste Management</h1>
    <div>
        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="fas fa-plus me-2"></i>Add Item
        </button>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#wasteReportModal">
            <i class="fas fa-trash me-2"></i>Record Waste
        </button>
    </div>
</div>

<!-- Alert Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-danger">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                <h5 class="card-title text-danger">Low Stock</h5>
                <h3>7</h3>
                <p class="text-muted">Items need restocking</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h5 class="card-title text-warning">Expiring Soon</h5>
                <h3>12</h3>
                <p class="text-muted">Items expire this week</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <i class="fas fa-dollar-sign fa-2x text-info mb-2"></i>
                <h5 class="card-title text-info">Total Value</h5>
                <h3>$15,420</h3>
                <p class="text-muted">Current inventory</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-danger">
            <div class="card-body text-center">
                <i class="fas fa-trash fa-2x text-danger mb-2"></i>
                <h5 class="card-title text-danger">Waste Today</h5>
                <h3>$127</h3>
                <p class="text-muted">2.1% of inventory</p>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Inventory Items</h5>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Search items...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Unit</th>
                        <th>Min Level</th>
                        <th>Unit Cost</th>
                        <th>Total Value</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Tomatoes</strong><br>
                            <small class="text-muted">Fresh Roma</small>
                        </td>
                        <td><span class="badge bg-success">Vegetables</span></td>
                        <td>15</td>
                        <td>lbs</td>
                        <td>20</td>
                        <td>$3.50</td>
                        <td>$52.50</td>
                        <td>2024-01-18</td>
                        <td><span class="badge bg-danger">Low Stock</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning" title="Record Usage">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Ground Beef</strong><br>
                            <small class="text-muted">80/20 Mix</small>
                        </td>
                        <td><span class="badge bg-danger">Meat</span></td>
                        <td>25</td>
                        <td>lbs</td>
                        <td>15</td>
                        <td>$6.99</td>
                        <td>$174.75</td>
                        <td>2024-01-17</td>
                        <td><span class="badge bg-warning">Expiring Soon</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning" title="Record Usage">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Mozzarella Cheese</strong><br>
                            <small class="text-muted">Whole Milk</small>
                        </td>
                        <td><span class="badge bg-info">Dairy</span></td>
                        <td>42</td>
                        <td>lbs</td>
                        <td>20</td>
                        <td>$4.25</td>
                        <td>$178.50</td>
                        <td>2024-01-25</td>
                        <td><span class="badge bg-success">Good</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning" title="Record Usage">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Inventory Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addItemForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" required>
                                    <option value="">Select category</option>
                                    <option value="vegetables">Vegetables</option>
                                    <option value="meat">Meat</option>
                                    <option value="dairy">Dairy</option>
                                    <option value="grains">Grains</option>
                                    <option value="beverages">Beverages</option>
                                    <option value="condiments">Condiments</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select" id="unit" required>
                                    <option value="">Select unit</option>
                                    <option value="lbs">lbs</option>
                                    <option value="kg">kg</option>
                                    <option value="oz">oz</option>
                                    <option value="gallons">gallons</option>
                                    <option value="liters">liters</option>
                                    <option value="pieces">pieces</option>
                                    <option value="cases">cases</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="unitCost" class="form-label">Unit Cost ($)</label>
                                <input type="number" class="form-control" id="unitCost" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="minLevel" class="form-label">Minimum Level</label>
                                <input type="number" class="form-control" id="minLevel" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" id="expiryDate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="addItem()">Add Item</button>
            </div>
        </div>
    </div>
</div>

<!-- Waste Report Modal -->
<div class="modal fade" id="wasteReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record Waste</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="wasteForm">
                    <div class="mb-3">
                        <label for="wasteItem" class="form-label">Item</label>
                        <select class="form-select" id="wasteItem" required>
                            <option value="">Select item</option>
                            <option value="1">Tomatoes</option>
                            <option value="2">Ground Beef</option>
                            <option value="3">Mozzarella Cheese</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="wasteQuantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="wasteQuantity" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="wasteReason" class="form-label">Reason</label>
                                <select class="form-select" id="wasteReason" required>
                                    <option value="">Select reason</option>
                                    <option value="expired">Expired</option>
                                    <option value="spoiled">Spoiled</option>
                                    <option value="damaged">Damaged</option>
                                    <option value="overcooked">Overcooked</option>
                                    <option value="customer_return">Customer Return</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="wasteNotes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="wasteNotes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="recordWaste()">Record Waste</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addItem() {
    alert('Item added successfully!');
    $('#addItemModal').modal('hide');
    document.getElementById('addItemForm').reset();
}

function recordWaste() {
    alert('Waste recorded successfully!');
    $('#wasteReportModal').modal('hide');
    document.getElementById('wasteForm').reset();
}
</script>
@endpush