@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<style>
.qr-code-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}

.app-suggestion-card {
    transition: transform 0.2s ease;
    cursor: pointer;
}

.app-suggestion-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.backup-code {
    font-family: 'Courier New', monospace;
    font-size: 14px;
    letter-spacing: 1px;
}

.qr-code-image {
    max-width: 200px;
    border: 1px solid #ddd;
    padding: 10px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.two-fa-step {
    border-left: 3px solid #28a745;
    padding-left: 15px;
}
</style>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Settings</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="pill">
                    <i class="fas fa-user me-2"></i>Profile
                </a>
                <a href="#restaurant" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                    <i class="fas fa-store me-2"></i>Restaurant Settings
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                    <i class="fas fa-bell me-2"></i>Notifications
                </a>
                <a href="#billing" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                    <i class="fas fa-credit-card me-2"></i>Billing
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                    <i class="fas fa-shield-alt me-2"></i>Security
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="tab-content">
            <!-- Profile Settings -->
            <div class="tab-pane fade show active" id="profile">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="profileForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $user->first_name ?? explode(' ', $user->name)[0] ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $user->last_name ?? (count(explode(' ', $user->name)) > 1 ? explode(' ', $user->name)[1] : '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone" name="timezone" required>
                                    <option value="UTC" {{ ($user->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="Asia/Jakarta" {{ ($user->timezone ?? 'UTC') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                    <option value="Asia/Makassar" {{ ($user->timezone ?? 'UTC') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                    <option value="Asia/Jayapura" {{ ($user->timezone ?? 'UTC') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                                    <option value="America/New_York" {{ ($user->timezone ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (ET)</option>
                                    <option value="America/Chicago" {{ ($user->timezone ?? 'UTC') == 'America/Chicago' ? 'selected' : '' }}>Central Time (CT)</option>
                                    <option value="America/Denver" {{ ($user->timezone ?? 'UTC') == 'America/Denver' ? 'selected' : '' }}>Mountain Time (MT)</option>
                                    <option value="America/Los_Angeles" {{ ($user->timezone ?? 'UTC') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (PT)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Restaurant Settings -->
            <div class="tab-pane fade" id="restaurant">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Restaurant Settings</h5>
                    </div>
                    <div class="card-body">
                        @if(!$selectedRestaurant)
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>No Restaurant Selected</strong><br>
                                Please select an active restaurant first from the restaurant management page before configuring restaurant settings.
                                <br><br>
                                <a href="{{ route('restaurants.index') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-store me-1"></i>Go to Restaurant Management
                                </a>
                            </div>
                        @else
                            <form id="restaurantForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="restaurantName" class="form-label">Restaurant Name</label>
                                    <input type="text" class="form-control" id="restaurantName" name="name" value="{{ $selectedRestaurant->name }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-select" id="category" name="category" required>
                                                <option value="fast-food" {{ $selectedRestaurant->category == 'fast-food' ? 'selected' : '' }}>Fast Food</option>
                                                <option value="casual-dining" {{ $selectedRestaurant->category == 'casual-dining' ? 'selected' : '' }}>Casual Dining</option>
                                                <option value="fine-dining" {{ $selectedRestaurant->category == 'fine-dining' ? 'selected' : '' }}>Fine Dining</option>
                                                <option value="cafe" {{ $selectedRestaurant->category == 'cafe' ? 'selected' : '' }}>Cafe</option>
                                                <option value="bakery" {{ $selectedRestaurant->category == 'bakery' ? 'selected' : '' }}>Bakery</option>
                                                <option value="food-truck" {{ $selectedRestaurant->category == 'food-truck' ? 'selected' : '' }}>Food Truck</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="currency" class="form-label">Currency</label>
                                            <select class="form-select" id="currency" name="currency" required>
                                                <option value="IDR" {{ ($selectedRestaurant->currency ?? 'IDR') == 'IDR' ? 'selected' : '' }}>IDR (Rp)</option>
                                                <option value="USD" {{ ($selectedRestaurant->currency ?? 'IDR') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                <option value="EUR" {{ ($selectedRestaurant->currency ?? 'IDR') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                <option value="GBP" {{ ($selectedRestaurant->currency ?? 'IDR') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $selectedRestaurant->address }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="restaurantPhone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="restaurantPhone" name="phone" value="{{ $selectedRestaurant->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="restaurantEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="restaurantEmail" name="email" value="{{ $selectedRestaurant->email }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Notifications -->
            <div class="tab-pane fade" id="notifications">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Notification Preferences</h5>
                    </div>
                    <div class="card-body">
                        <form id="notificationsForm">
                            @csrf
                            <div class="mb-4">
                                <h6>Email Notifications</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="forecastReady" name="forecast_ready" {{ ($user->notification_forecast_ready ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="forecastReady">Forecast Analysis Ready</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="systemUpdates" name="system_updates" {{ ($user->notification_system_updates ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="systemUpdates">System Updates</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="forecastNextMonth" name="forecast_next_month" {{ ($user->notification_forecast_next_month ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="forecastNextMonth">Forecast Next Month Ready</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Billing -->
            <div class="tab-pane fade" id="billing">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Billing & Subscription</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h6>Current Plan: Basic</h6>
                                <p class="text-muted">Rp 1,000,000/month - Next billing date: November 10, 2025</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#planModal">Change Plan</button>
                            </div>
                        </div>
                        
                        <!-- Subscription Plans -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6>Available Plans</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white text-center">
                                                <h6 class="mb-0">Basic</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="text-primary">Rp 1,000,000</h4>
                                                <p class="text-muted">/month</p>
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>Up to 2 restaurants</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Basic forecasting</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Email support</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Monthly reports</li>
                                                </ul>
                                                <button class="btn btn-primary btn-sm">Current Plan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white text-center">
                                                <h6 class="mb-0">Pro</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="text-success">Rp 5,000,000</h4>
                                                <p class="text-muted">/month</p>
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>Unlimited restaurants</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Advanced forecasting</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>What-if scenarios</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Priority support</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Real-time reports</li>
                                                </ul>
                                                <button class="btn btn-success btn-sm">Upgrade</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-warning">
                                            <div class="card-header bg-warning text-dark text-center">
                                                <h6 class="mb-0">Enterprise</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="text-warning">Contact Us</h4>
                                                <p class="text-muted">Custom pricing</p>
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-check text-success me-2"></i>Everything in Pro</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Custom integrations</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Dedicated support</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>Custom reports</li>
                                                    <li><i class="fas fa-check text-success me-2"></i>API access</li>
                                                </ul>
                                                <button class="btn btn-warning btn-sm">Contact Sales</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-light mb-4">
                            <div class="card-body">
                                <h6>Payment Method</h6>
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-cc-visa fa-2x text-primary me-3"></i>
                                    <div>
                                        <strong>•••• •••• •••• 4242</strong><br>
                                        <small class="text-muted">Expires 12/2026</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary ms-auto">Update</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-light">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Invoices</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($invoices as $invoice)
                                                <tr>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($invoice->currency === 'IDR')
                                                            Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                                        @else
                                                            {{ $invoice->currency }} {{ number_format($invoice->amount, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($invoice->status === 'paid')
                                                            <span class="badge bg-success">Paid</span>
                                                        @elseif($invoice->status === 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($invoice->status === 'failed')
                                                            <span class="badge bg-danger">Failed</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($invoice->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($invoice->status === 'paid')
                                                            <button class="btn btn-sm btn-outline-primary">Download</button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline-secondary" disabled>-</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No invoices found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security -->
            <div class="tab-pane fade" id="security">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Security Settings</h5>
                    </div>
                    <div class="card-body">
                        <!-- Change Password -->
                        <div class="mb-4">
                            <h6>Change Password</h6>
                            <form id="passwordForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                        
                        <!-- Two-Factor Authentication -->
                        <div class="mb-4">
                            <h6>Two-Factor Authentication</h6>
                            <p class="text-muted">Add an extra layer of security to your account.</p>
                            @if($user->two_factor_enabled ?? false)
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-shield-alt me-2"></i>2FA is currently <strong>enabled</strong> for your account.
                                </div>
                                <button class="btn btn-outline-danger" id="disable2FA">Disable 2FA</button>
                            @else
                                <button class="btn btn-outline-success" id="enable2FA">Enable 2FA</button>
                            @endif
                        </div>
                        
                        <!-- Danger Zone -->
                        <div>
                            <h6 class="text-danger">Danger Zone</h6>
                            <p class="text-muted">These actions cannot be undone. Your account will be deleted permanently after 31 days.</p>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2FA Setup Modal -->
<div class="modal fade" id="twoFAModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enable Two-Factor Authentication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="twoFASetup">
                    <!-- Security Information -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Why Enable 2FA?</h6>
                        <ul class="mb-0 small">
                            <li>Protects your account even if your password is compromised</li>
                            <li>Prevents unauthorized access to your restaurant data</li>
                            <li>Industry standard security practice</li>
                            <li>Can be used offline (no internet required for codes)</li>
                        </ul>
                    </div>

                    <!-- Step 1: Download App Instructions -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Step 1: Download an Authenticator App</h6>
                        <p class="text-muted mb-3">Download and install one of these free authenticator apps on your mobile device:</p>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-primary">
                                    <div class="card-body text-center">
                                        <i class="fab fa-google fa-2x text-primary mb-2"></i>
                                        <h6 class="card-title mb-1">Google Authenticator</h6>
                                        <small class="text-muted">Free • Most Popular</small>
                                        <div class="mt-2">
                                            <a href="https://apps.apple.com/app/google-authenticator/id388497605" target="_blank" class="btn btn-sm btn-outline-primary me-1">iOS</a>
                                            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank" class="btn btn-sm btn-outline-primary">Android</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-info">
                                    <div class="card-body text-center">
                                        <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                                        <h6 class="card-title mb-1">Microsoft Authenticator</h6>
                                        <small class="text-muted">Free • Enterprise Ready</small>
                                        <div class="mt-2">
                                            <a href="https://apps.apple.com/app/microsoft-authenticator/id983156458" target="_blank" class="btn btn-sm btn-outline-info me-1">iOS</a>
                                            <a href="https://play.google.com/store/apps/details?id=com.azure.authenticator" target="_blank" class="btn btn-sm btn-outline-info">Android</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-key fa-2x text-success mb-2"></i>
                                        <h6 class="card-title mb-1">Authy</h6>
                                        <small class="text-muted">Free • Multi-Device</small>
                                        <div class="mt-2">
                                            <a href="https://apps.apple.com/app/authy/id494168017" target="_blank" class="btn btn-sm btn-outline-success me-1">iOS</a>
                                            <a href="https://play.google.com/store/apps/details?id=com.authy.authy" target="_blank" class="btn btn-sm btn-outline-success">Android</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: QR Code -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Step 2: Scan QR Code</h6>
                        <p class="text-muted">Open your authenticator app and scan this QR code:</p>
                        
                        <div class="alert alert-info mb-3">
                            <small><i class="fas fa-info-circle me-1"></i>
                            <strong>Fast & Reliable:</strong> QR codes are generated using premium third-party APIs for optimal performance and reliability.
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center p-3 border rounded">
                                    <div id="qrCodeContainer">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading QR Code...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">Can't scan the QR code?</h6>
                                    <p class="mb-2">Manually enter this secret key in your authenticator app:</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control font-monospace" id="secretKey" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="copySecret()" title="Copy to clipboard">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <h6 class="small fw-bold">Or open this link in your authenticator app:</h6>
                                        <div class="input-group">
                                            <input type="text" class="form-control small" id="manualSetupUrl" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="copyManualUrl()" title="Copy URL">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Verify -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Step 3: Enter Verification Code</h6>
                        <p class="text-muted">Enter the 6-digit code from your authenticator app to complete setup:</p>
                        <form id="verify2FAForm">
                            @csrf
                            <div class="mb-3">
                                <label for="verificationCode" class="form-label">6-Digit Verification Code</label>
                                <input type="text" class="form-control text-center" id="verificationCode" name="code" maxlength="6" placeholder="000000" required>
                                <div class="form-text">The code changes every 30 seconds</div>
                            </div>
                            
                            <!-- Troubleshooting -->
                            <div class="accordion accordion-flush mb-3" id="troubleshootingAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#troubleshooting" aria-expanded="false">
                                            <small><i class="fas fa-question-circle me-2"></i>Having trouble? Click for help</small>
                                        </button>
                                    </h2>
                                    <div id="troubleshooting" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body small">
                                            <ul class="mb-0">
                                                <li><strong>Code not working?</strong> Make sure your phone's time is synchronized</li>
                                                <li><strong>Can't scan QR?</strong> Use the manual secret key above</li>
                                                <li><strong>App not listed?</strong> Any TOTP authenticator app will work</li>
                                                <li><strong>Lost your phone?</strong> Contact support with your backup codes</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-shield-alt me-2"></i>Verify & Enable 2FA
                            </button>
                        </form>
                    </div>

                    <!-- Backup Codes Section -->
                    <div id="backupCodesSection" style="display: none;">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">Save Your Backup Codes</h6>
                            <p class="mb-2">Keep these backup codes safe. You can use them to access your account if you lose your phone:</p>
                            <div id="backupCodes" class="font-monospace small"></div>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-warning" onclick="downloadBackupCodes()">
                                    <i class="fas fa-download me-1"></i>Download Codes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disable2FAModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disable Two-Factor Authentication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="disable2FAForm">
                    @csrf
                    <div class="mb-3">
                        <label for="disable2FAPassword" class="form-label">Confirm your password to disable 2FA</label>
                        <input type="password" class="form-control" id="disable2FAPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Disable 2FA</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Warning:</strong> This action cannot be undone. Your account will be deactivated immediately and permanently deleted after 31 days along with all associated restaurants and data.
                </div>
                <form id="deleteAccountForm">
                    @csrf
                    <div class="mb-3">
                        <label for="deletePassword" class="form-label">Confirm your password</label>
                        <input type="password" class="form-control" id="deletePassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="deleteConfirmation" class="form-label">Type "DELETE" to confirm</label>
                        <input type="text" class="form-control" id="deleteConfirmation" name="confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Delete My Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF token setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Profile form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        console.log("Submitting profile form");
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.profile.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while updating profile');
        });
    });

    // Restaurant form submission
    const restaurantForm = document.getElementById('restaurantForm');
    if (restaurantForm) {
        restaurantForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("settings.restaurant.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred while updating restaurant settings');
            });
        });
    }

    // Notifications form submission
    document.getElementById('notificationsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.notifications.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while updating notification preferences');
        });
    });

    // Password form submission
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.password.change") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                this.reset();
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while changing password');
        });
    });

    // 2FA Enable
    const enable2FABtn = document.getElementById('enable2FA');
    if (enable2FABtn) {
        enable2FABtn.addEventListener('click', function() {
            fetch('{{ route("settings.2fa.enable") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Set the secret key
                    document.getElementById('secretKey').value = data.secret;
                    
                    // Set the manual setup URL
                    if (data.qr_code_url) {
                        document.getElementById('manualSetupUrl').value = data.qr_code_url;
                    }
                    
                    // Display QR code using third-party API with fallbacks
                    const qrContainer = document.getElementById('qrCodeContainer');
                    
                    if (data.qr_code_apis) {
                        // Try multiple APIs with fallback system
                        const apis = data.qr_code_apis;
                        let apiUrls = [apis.qr_server, apis.google_chart, apis.quickchart].filter(Boolean);
                        
                        if (apiUrls.length > 0) {
                            qrContainer.innerHTML = `
                                <img src="${apiUrls[0]}" 
                                     alt="2FA QR Code" 
                                     class="qr-code-image img-fluid"
                                     data-fallback-urls='${JSON.stringify(apiUrls.slice(1))}'
                                     onload="this.style.opacity='1'; showQRSuccess();"
                                     onerror="handleQRError(this);"
                                     style="opacity: 0; transition: opacity 0.3s ease;">
                                <div class="text-center mt-2">
                                    <small class="text-muted">Scan with your authenticator app</small>
                                </div>
                                <div id="qr-loading" class="text-center" style="display: none;">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading alternative QR code...</span>
                                    </div>
                                    <small class="d-block mt-1 text-muted">Loading QR code...</small>
                                </div>
                            `;
                        } else {
                            qrContainer.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>QR Code APIs not available. Please use the manual secret key below.</div>';
                        }
                    } else {
                        console.error('No QR code APIs available:', data);
                        qrContainer.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>QR Code generation failed. Please use the manual secret key below.</div>';
                    }
                    
                    // Store backup codes for later use
                    window.backupCodes = data.backup_codes;
                    
                    // Show the modal
                    new bootstrap.Modal(document.getElementById('twoFAModal')).show();
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred while enabling 2FA');
            });
        });
    }

    // QR Code fallback system
    window.handleQRError = function(img) {
        const fallbackUrls = JSON.parse(img.getAttribute('data-fallback-urls') || '[]');
        
        if (fallbackUrls.length > 0) {
            // Show loading indicator
            const loadingDiv = document.getElementById('qr-loading');
            if (loadingDiv) loadingDiv.style.display = 'block';
            
            // Try next URL
            const nextUrl = fallbackUrls.shift();
            img.setAttribute('data-fallback-urls', JSON.stringify(fallbackUrls));
            
            setTimeout(() => {
                img.src = nextUrl;
                if (loadingDiv) loadingDiv.style.display = 'none';
            }, 500);
        } else {
            // All APIs failed, show manual option
            img.parentElement.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>QR Code not available</strong><br>
                    Please use the manual secret key or setup URL below.
                </div>
            `;
        }
    };

    window.showQRSuccess = function() {
        const loadingDiv = document.getElementById('qr-loading');
        if (loadingDiv) loadingDiv.style.display = 'none';
    };

    // Copy secret key function
    window.copySecret = function() {
        const secretInput = document.getElementById('secretKey');
        secretInput.select();
        secretInput.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(secretInput.value).then(function() {
            showAlert('success', 'Secret key copied to clipboard!');
        }, function() {
            showAlert('warning', 'Failed to copy. Please copy manually.');
        });
    };

    // Copy manual setup URL function
    window.copyManualUrl = function() {
        const urlInput = document.getElementById('manualSetupUrl');
        urlInput.select();
        urlInput.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(urlInput.value).then(function() {
            showAlert('success', 'Setup URL copied to clipboard!');
        }, function() {
            showAlert('warning', 'Failed to copy URL. Please copy manually.');
        });
    };

    // Download backup codes function
    window.downloadBackupCodes = function() {
        if (!window.backupCodes) return;
        
        const content = config('app.name', 'GastroCast') . ' Two-Factor Authentication Backup Codes\n' +
                       'Generated: ' + new Date().toLocaleString() + '\n\n' +
                       'Keep these codes safe. Each code can only be used once.\n\n' +
                       window.backupCodes.join('\n');
        
        const blob = new Blob([content], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = '{{ strtolower(preg_replace('/[^a-zA-Z0-9]/', '', config('app.name', 'gastrocast'))) }}-2fa-backup-codes.txt';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    };

    // 2FA Verification
    document.getElementById('verify2FAForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.2fa.verify") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show backup codes section
                if (window.backupCodes) {
                    const backupCodesDiv = document.getElementById('backupCodes');
                    backupCodesDiv.innerHTML = window.backupCodes.map(code => 
                        `<div class="badge bg-light text-dark me-2 mb-1">${code}</div>`
                    ).join('');
                    document.getElementById('backupCodesSection').style.display = 'block';
                    
                    // Hide the form and show success message
                    document.getElementById('verify2FAForm').style.display = 'none';
                    showAlert('success', data.message + ' Please save your backup codes above!');
                    
                    // Auto-close modal after codes are shown
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('twoFAModal')).hide();
                        location.reload();
                    }, 10000);
                } else {
                    showAlert('success', data.message);
                    bootstrap.Modal.getInstance(document.getElementById('twoFAModal')).hide();
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while verifying 2FA');
        });
    });

    // 2FA Disable
    const disable2FABtn = document.getElementById('disable2FA');
    if (disable2FABtn) {
        disable2FABtn.addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('disable2FAModal')).show();
        });
    }

    document.getElementById('disable2FAForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.2fa.disable") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                bootstrap.Modal.getInstance(document.getElementById('disable2FAModal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while disabling 2FA');
        });
    });

    // Delete account form
    document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("settings.account.delete") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }, 2000);
            } else {
                showAlert('danger', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while deleting account');
        });
    });

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at the top of the content
        const contentDiv = document.querySelector('.tab-content');
        contentDiv.insertBefore(alertDiv, contentDiv.firstChild);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endsection
@endsection