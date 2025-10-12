@extends('layouts.app')

@section('title', $restaurant->name . '')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>{{ $restaurant->name }}</h1>
        <p class="text-muted mb-0">{{ $restaurant->category }} • {{ $restaurant->address }}</p>
    </div>
    <div>
        <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Restaurant Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Name:</dt>
                            <dd class="col-sm-8">{{ $restaurant->name }}</dd>
                            
                            <dt class="col-sm-4">Category:</dt>
                            <dd class="col-sm-8">{{ $restaurant->category ?: 'Not specified' }}</dd>
                            
                            <dt class="col-sm-4">Phone:</dt>
                            <dd class="col-sm-8">{{ $restaurant->phone ?: 'Not provided' }}</dd>
                            
                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8">{{ $restaurant->email ?: 'Not provided' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Timezone:</dt>
                            <dd class="col-sm-8">{{ $restaurant->timezone }}</dd>
                            
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                <span class="badge {{ $restaurant->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                            
                            <dt class="col-sm-4">Created:</dt>
                            <dd class="col-sm-8">{{ $restaurant->created_at->format('M j, Y') }}</dd>
                            
                            <dt class="col-sm-4">Updated:</dt>
                            <dd class="col-sm-8">{{ $restaurant->updated_at->format('M j, Y') }}</dd>
                        </dl>
                    </div>
                </div>
                
                @if($restaurant->address)
                <div class="row mt-3">
                    <div class="col-12">
                        <strong>Address:</strong>
                        <p class="mb-0">{{ $restaurant->address }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="selectRestaurant({{ $restaurant->id }})">
                        <i class="fas fa-check me-2"></i>Select as Active
                    </button>
                    <a href="{{ route('datasets.index') }}?restaurant={{ $restaurant->id }}" class="btn btn-outline-info">
                        <i class="fas fa-database me-2"></i>View Data
                    </a>
                    <a href="{{ route('forecast.index') }}?restaurant={{ $restaurant->id }}" class="btn btn-outline-success">
                        <i class="fas fa-chart-line me-2"></i>Run Forecast
                    </a>
                    <a href="{{ route('menu-engineering.index') }}?restaurant={{ $restaurant->id }}" class="btn btn-outline-warning">
                        <i class="fas fa-utensils me-2"></i>Analyze Menu
                    </a>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                        <i class="fas fa-trash me-1"></i>Delete Restaurant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="restaurantName"></strong>?</p>
                <p class="text-danger">This action cannot be undone and will remove all associated data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Restaurant</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectRestaurant(restaurantId) {
    // Make AJAX call to select restaurant
    fetch(`/api/restaurants/${restaurantId}/select`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        alert('Restaurant selected successfully!');
        
        // Store in session storage for frontend access
        sessionStorage.setItem('selected_restaurant_id', restaurantId);
        
        // Redirect to dashboard to see filtered data
        window.location.href = '/dashboard';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to select restaurant. Please try again.');
    });
}

function confirmDelete(restaurantId, restaurantName) {
    document.getElementById('restaurantName').textContent = restaurantName;
    document.getElementById('deleteForm').action = `/restaurants/${restaurantId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush