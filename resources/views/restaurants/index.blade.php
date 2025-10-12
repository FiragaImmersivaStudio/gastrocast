@extends('layouts.app')

@section('title', 'Restaurants')

@section('styles')
<style>
.is-valid {
    border-color: #198754 !important;
}
.is-invalid {
    border-color: #dc3545 !important;
}
.valid-feedback {
    display: block;
    color: #198754;
    font-size: 0.875em;
}
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h1>My Restaurants</h1>
    <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Restaurant
    </a>
</div>

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
                            @if($restaurant->owner_user_id === auth()->id())
                                <span class="badge bg-primary">Owner</span>
                            @else
                                @php
                                    $userRole = auth()->user()->getRoleForRestaurant($restaurant->id);
                                @endphp
                                @if($userRole)
                                    <span class="badge bg-info">{{ ucfirst($userRole) }}</span>
                                @endif
                            @endif
                        </div>
                        
                        @if($restaurant->owner_user_id === auth()->id() && $restaurant->users->count() > 1)
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $restaurant->users->count() }} team members
                                </small>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            @if($restaurant->owner_user_id === auth()->id())
                                <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" 
                                        onclick="showInviteModal({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                                    <i class="fas fa-user-plus me-1"></i>Invite
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            @endif
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

<!-- Invite user modal -->
<div class="modal fade" id="inviteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invite User to <span id="inviteRestaurantName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="inviteForm">
                @csrf
                <div class="modal-body">
                    <div id="inviteAlert" class="alert d-none" role="alert"></div>
                    
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">User Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                        <div id="emailFeedback" class="invalid-feedback"></div>
                        <div id="emailValidFeedback" class="valid-feedback"></div>
                        <small class="form-text text-muted">Enter the email of the user you want to invite.</small>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-select" id="userRole" name="role" required>
                            <option value="">Select a role</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                        </select>
                        <div id="roleFeedback" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="inviteSubmitBtn">
                        <span id="inviteSpinner" class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                        Send Invitation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentRestaurantId = null;
let emailValidationTimeout = null;

function confirmDelete(restaurantId, restaurantName) {
    document.getElementById('restaurantName').textContent = restaurantName;
    document.getElementById('deleteForm').action = `/restaurants/${restaurantId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function showInviteModal(restaurantId, restaurantName) {
    currentRestaurantId = restaurantId;
    document.getElementById('inviteRestaurantName').textContent = restaurantName;
    document.getElementById('userEmail').value = '';
    document.getElementById('userRole').value = '';
    clearValidationMessages();
    new bootstrap.Modal(document.getElementById('inviteModal')).show();
}

function clearValidationMessages() {
    const emailInput = document.getElementById('userEmail');
    const roleInput = document.getElementById('userRole');
    const alert = document.getElementById('inviteAlert');
    
    emailInput.classList.remove('is-valid', 'is-invalid');
    roleInput.classList.remove('is-invalid');
    alert.classList.add('d-none');
    document.getElementById('emailFeedback').textContent = '';
    document.getElementById('emailValidFeedback').textContent = '';
    document.getElementById('roleFeedback').textContent = '';
}

function showAlert(message, type = 'danger') {
    const alert = document.getElementById('inviteAlert');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    alert.classList.remove('d-none');
}

function validateEmail() {
    const email = document.getElementById('userEmail').value.trim();
    const emailInput = document.getElementById('userEmail');
    
    if (!email) {
        emailInput.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    // Basic email format validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        emailInput.classList.remove('is-valid');
        emailInput.classList.add('is-invalid');
        document.getElementById('emailFeedback').textContent = 'Please enter a valid email address.';
        return;
    }
    
    // Clear previous timeout
    if (emailValidationTimeout) {
        clearTimeout(emailValidationTimeout);
    }
    
    // Set new timeout for AJAX validation
    emailValidationTimeout = setTimeout(() => {
        fetch('/api/check-user-exists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
                document.getElementById('emailValidFeedback').textContent = `User found: ${data.user.name}`;
            } else {
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
                document.getElementById('emailFeedback').textContent = 'User with this email not found.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            emailInput.classList.remove('is-valid');
            emailInput.classList.add('is-invalid');
            document.getElementById('emailFeedback').textContent = 'Error checking email. Please try again.';
        });
    }, 500); // Wait 500ms after user stops typing
}

// Event listeners
document.getElementById('userEmail').addEventListener('input', validateEmail);
document.getElementById('userEmail').addEventListener('blur', validateEmail);

document.getElementById('inviteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('inviteSubmitBtn');
    const spinner = document.getElementById('inviteSpinner');
    const emailInput = document.getElementById('userEmail');
    const roleInput = document.getElementById('userRole');
    
    // Validate form
    let isValid = true;
    
    if (!emailInput.value.trim()) {
        emailInput.classList.add('is-invalid');
        document.getElementById('emailFeedback').textContent = 'Email is required.';
        isValid = false;
    }
    
    if (!roleInput.value) {
        roleInput.classList.add('is-invalid');
        document.getElementById('roleFeedback').textContent = 'Role is required.';
        isValid = false;
    } else {
        roleInput.classList.remove('is-invalid');
    }
    
    if (!isValid) {
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    clearValidationMessages();
    
    const formData = new FormData(this);
    
    fetch(`/api/restaurants/${currentRestaurantId}/invite-ajax`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            
            // Add new user to the team display if we're on the show page
            if (typeof addUserToTeamTable === 'function') {
                addUserToTeamTable(data.user);
            }
            
            // Reset form
            document.getElementById('inviteForm').reset();
            clearValidationMessages();
            
            // Show success message and close modal after delay
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('inviteModal')).hide();
                
                // Show global success message
                if (typeof showGlobalMessage === 'function') {
                    showGlobalMessage(data.message, 'success');
                } else {
                    // Fallback: reload page to show updated data
                    location.reload();
                }
            }, 2000);
        } else {
            showAlert(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred. Please try again.', 'danger');
    })
    .finally(() => {
        // Hide loading state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
    });
});
</script>
@endsection