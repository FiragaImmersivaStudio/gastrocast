@extends('layouts.app')

@section('title', $restaurant->name . '')

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
.toast-container {
    z-index: 1055;
}
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <div>
        <h1>{{ $restaurant->name }}</h1>
        <p class="text-muted mb-0">{{ $restaurant->category }} • {{ $restaurant->address }}</p>
    </div>
    <div>
        @if($restaurant->owner_user_id === auth()->id())
            <a href="{{ route('restaurants.edit', $restaurant) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
        @endif
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

        @if($restaurant->owner_user_id === auth()->id())
            <!-- Team Management Section -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Team Members</h5>
                    <button class="btn btn-sm btn-primary" onclick="showInviteModal({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                        <i class="fas fa-user-plus me-1"></i>Invite User
                    </button>
                </div>
                <div class="card-body">
                    @if($restaurant->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm" id="teamTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($restaurant->users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->id === $restaurant->owner_user_id)
                                                    <span class="badge bg-primary">Owner</span>
                                                @else
                                                    <span class="badge bg-info">{{ ucfirst($user->pivot->role) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->pivot->joined_at ? \Carbon\Carbon::parse($user->pivot->joined_at)->format('M j, Y') : '-' }}</td>
                                            <td>
                                                @if($user->id !== $restaurant->owner_user_id)
                                                    <button class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmRemoveUser({{ $restaurant->id }}, {{ $user->id }}, '{{ $user->name }}')">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No team members yet. Invite users to collaborate on this restaurant.</p>
                    @endif
                </div>
            </div>
        @endif
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
                
                @if($restaurant->owner_user_id === auth()->id())
                    <div class="text-center">
                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $restaurant->id }}, '{{ $restaurant->name }}')">
                            <i class="fas fa-trash me-1"></i>Delete Restaurant
                        </button>
                    </div>
                @endif
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

<!-- Remove user confirmation modal -->
<div class="modal fade" id="removeUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove <strong id="removeUserName"></strong> from this restaurant?</p>
                <p class="text-warning">They will no longer have access to this restaurant's data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="removeUserForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="removeUserId" name="user_id">
                    <button type="submit" class="btn btn-danger">Remove User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentRestaurantId = {{ $restaurant->id }};
let emailValidationTimeout = null;

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

function showInviteModal(restaurantId, restaurantName) {
    currentRestaurantId = restaurantId;
    document.getElementById('inviteRestaurantName').textContent = restaurantName;
    document.getElementById('userEmail').value = '';
    document.getElementById('userRole').value = '';
    clearValidationMessages();
    new bootstrap.Modal(document.getElementById('inviteModal')).show();
}

function confirmRemoveUser(restaurantId, userId, userName) {
    document.getElementById('removeUserName').textContent = userName;
    document.getElementById('removeUserForm').action = `/restaurants/${restaurantId}/remove-user`;
    document.getElementById('removeUserId').value = userId;
    new bootstrap.Modal(document.getElementById('removeUserModal')).show();
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

function addUserToTeamTable(user) {
    const tbody = document.querySelector('#teamTable tbody');
    if (!tbody) return;
    
    const newRow = `
        <tr>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td><span class="badge bg-info">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span></td>
            <td>${user.joined_at}</td>
            <td>
                <button class="btn btn-sm btn-outline-danger" 
                        onclick="confirmRemoveUser(${currentRestaurantId}, ${user.id}, '${user.name}')">
                    <i class="fas fa-user-minus"></i>
                </button>
            </td>
        </tr>
    `;
    
    tbody.insertAdjacentHTML('beforeend', newRow);
    
    // Update team member count if displayed
    const countElement = document.querySelector('.team-count');
    if (countElement) {
        const currentCount = parseInt(countElement.textContent) || 0;
        countElement.textContent = currentCount + 1;
    }
}

function showGlobalMessage(message, type) {
    // Create and show a toast notification
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '1055';
    document.body.appendChild(container);
    return container;
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('userEmail');
    const inviteForm = document.getElementById('inviteForm');
    
    if (emailInput) {
        emailInput.addEventListener('input', validateEmail);
        emailInput.addEventListener('blur', validateEmail);
    }
    
    if (inviteForm) {
        inviteForm.addEventListener('submit', function(e) {
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
                    
                    // Add new user to the team table
                    addUserToTeamTable(data.user);
                    
                    // Reset form
                    document.getElementById('inviteForm').reset();
                    clearValidationMessages();
                    
                    // Close modal after delay
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('inviteModal')).hide();
                        showGlobalMessage(data.message, 'success');
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
    }
});
</script>
@endsection