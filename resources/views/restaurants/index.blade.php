@extends('layouts.app')

@section('title', 'Restaurants - GastroCast')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>My Restaurants</h1>
    <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Restaurant
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($restaurants->count() > 0)
    <div class="row">
        @foreach($restaurants as $restaurant)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $restaurant->name }}</h5>
                        
                        @if($restaurant->category)
                            <p class="text-muted mb-2">
                                <i class="fas fa-tag me-1"></i>{{ $restaurant->category }}
                            </p>
                        @endif
                        
                        @if($restaurant->address)
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($restaurant->address, 50) }}
                            </p>
                        @endif
                        
                        @if($restaurant->phone)
                            <p class="text-muted mb-2">
                                <i class="fas fa-phone me-1"></i>{{ $restaurant->phone }}
                            </p>
                        @endif
                        
                        <div class="mb-2">
                            <span class="badge {{ $restaurant->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="confirmDelete({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $restaurants->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-store fa-3x text-muted mb-3"></i>
        <h3 class="text-muted">No Restaurants Yet</h3>
        <p class="text-muted">Get started by adding your first restaurant.</p>
        <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Your First Restaurant
        </a>
    </div>
@endif

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
                <p class="text-danger">This action cannot be undone.</p>
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
function confirmDelete(restaurantId, restaurantName) {
    document.getElementById('restaurantName').textContent = restaurantName;
    document.getElementById('deleteForm').action = `/restaurants/${restaurantId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush