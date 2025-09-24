@extends('layouts.app')

@section('title', 'Settings - GastroCast')

@section('content')
<div class="row">
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
                <a href="#integrations" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                    <i class="fas fa-plug me-2"></i>Integrations
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
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone">
                                    <option value="UTC">UTC</option>
                                    <option value="America/New_York">Eastern Time (ET)</option>
                                    <option value="America/Chicago">Central Time (CT)</option>
                                    <option value="America/Denver">Mountain Time (MT)</option>
                                    <option value="America/Los_Angeles">Pacific Time (PT)</option>
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
                        <form>
                            <div class="mb-3">
                                <label for="restaurantName" class="form-label">Restaurant Name</label>
                                <input type="text" class="form-control" id="restaurantName" value="The Gourmet Burger">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" id="category">
                                            <option value="fast-food">Fast Food</option>
                                            <option value="casual-dining" selected>Casual Dining</option>
                                            <option value="fine-dining">Fine Dining</option>
                                            <option value="cafe">Cafe</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Currency</label>
                                        <select class="form-select" id="currency">
                                            <option value="USD" selected>USD ($)</option>
                                            <option value="EUR">EUR (€)</option>
                                            <option value="GBP">GBP (£)</option>
                                            <option value="IDR">IDR (Rp)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" rows="3">123 Main Street, Downtown, City 12345</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" value="(555) 123-4567">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="info@gourmetburger.com">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
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
                        <div class="mb-4">
                            <h6>Email Notifications</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dailyReports" checked>
                                <label class="form-check-label" for="dailyReports">Daily Sales Reports</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lowStock" checked>
                                <label class="form-check-label" for="lowStock">Low Stock Alerts</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="forecastReady">
                                <label class="form-check-label" for="forecastReady">Forecast Analysis Ready</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="systemUpdates">
                                <label class="form-check-label" for="systemUpdates">System Updates</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h6>Push Notifications</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushAlerts" checked>
                                <label class="form-check-label" for="pushAlerts">Critical Alerts</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushReports">
                                <label class="form-check-label" for="pushReports">Report Notifications</label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="emailFrequency" class="form-label">Email Report Frequency</label>
                            <select class="form-select" id="emailFrequency">
                                <option value="daily" selected>Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="never">Never</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Preferences</button>
                    </div>
                </div>
            </div>
            
            <!-- Integrations -->
            <div class="tab-pane fade" id="integrations">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Integrations</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fab fa-square-instagram fa-2x text-danger mb-2"></i>
                                        <h6>POS System</h6>
                                        <p class="text-muted small">Connect your point of sale system</p>
                                        <button class="btn btn-sm btn-outline-primary">Connect</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-credit-card fa-2x text-success mb-2"></i>
                                        <h6>Payment Gateway</h6>
                                        <p class="text-muted small">Stripe, PayPal integration</p>
                                        <button class="btn btn-sm btn-success">Connected</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-truck fa-2x text-warning mb-2"></i>
                                        <h6>Delivery Services</h6>
                                        <p class="text-muted small">DoorDash, UberEats, Grubhub</p>
                                        <button class="btn btn-sm btn-outline-primary">Connect</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                        <h6>Analytics Tools</h6>
                                        <p class="text-muted small">Google Analytics, Facebook Pixel</p>
                                        <button class="btn btn-sm btn-outline-primary">Connect</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <h6>Current Plan: Professional</h6>
                                <p class="text-muted">$49/month - Next billing date: February 15, 2024</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-outline-primary">Change Plan</button>
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
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jan 15, 2024</td>
                                                <td>$49.00</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td><button class="btn btn-sm btn-outline-primary">Download</button></td>
                                            </tr>
                                            <tr>
                                                <td>Dec 15, 2023</td>
                                                <td>$49.00</td>
                                                <td><span class="badge bg-success">Paid</span></td>
                                                <td><button class="btn btn-sm btn-outline-primary">Download</button></td>
                                            </tr>
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
                        <div class="mb-4">
                            <h6>Change Password</h6>
                            <form>
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                        
                        <div class="mb-4">
                            <h6>Two-Factor Authentication</h6>
                            <p class="text-muted">Add an extra layer of security to your account.</p>
                            <button class="btn btn-outline-success">Enable 2FA</button>
                        </div>
                        
                        <div class="mb-4">
                            <h6>Active Sessions</h6>
                            <div class="card border-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Current Session</strong><br>
                                            <small class="text-muted">Chrome on Windows - 192.168.1.100</small>
                                        </div>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h6 class="text-danger">Danger Zone</h6>
                            <p class="text-muted">These actions cannot be undone.</p>
                            <button class="btn btn-outline-danger">Delete Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection