@extends('layouts.app')

@section('title', 'Add Restaurant')

@section('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; width: 100%; border-radius: 8px; }
    .mall-fields { display: none; }
</style>
@endsection

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Add New Restaurant</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('restaurants.store') }}" id="restaurantForm">
                    @csrf

                    <!-- Restaurant Name -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror"
                                        id="category" name="category">
                                    <option value="">Select a category</option>
                                    <option value="Fast Food" {{ old('category') == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                                    <option value="Fine Dining" {{ old('category') == 'Fine Dining' ? 'selected' : '' }}>Fine Dining</option>
                                    <option value="Casual Dining" {{ old('category') == 'Casual Dining' ? 'selected' : '' }}>Casual Dining</option>
                                    <option value="Cafe" {{ old('category') == 'Cafe' ? 'selected' : '' }}>Cafe</option>
                                    <option value="Pizza" {{ old('category') == 'Pizza' ? 'selected' : '' }}>Pizza</option>
                                    <option value="Asian" {{ old('category') == 'Asian' ? 'selected' : '' }}>Asian</option>
                                    <option value="Mexican" {{ old('category') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                                    <option value="Italian" {{ old('category') == 'Italian' ? 'selected' : '' }}>Italian</option>
                                    <option value="Bakery" {{ old('category') == 'Bakery' ? 'selected' : '' }}>Bakery</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Coordinates with Leaflet Map -->
                    <div class="mb-3">
                        <label class="form-label">Location Coordinates</label>
                        <div id="map"></div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror"
                                       id="latitude" name="latitude" placeholder="Latitude" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror"
                                       id="longitude" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <small class="text-muted">Click on the map to set coordinates or enter manually</small>
                    </div>

                    <!-- Contact Information -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror"
                                       id="website" name="website" value="{{ old('website') }}" placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Timezone -->
                    <div class="mb-3">
                        <label for="timezone" class="form-label">Timezone *</label>
                        <select class="form-select @error('timezone') is-invalid @enderror"
                                id="timezone" name="timezone" required>
                            <option value="">Select timezone</option>
                            <option value="Asia/Jakarta" {{ old('timezone') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB - Jakarta (UTC+7)</option>
                            <option value="Asia/Makassar" {{ old('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>WITA - Makassar (UTC+8)</option>
                            <option value="Asia/Jayapura" {{ old('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT - Jayapura (UTC+9)</option>
                            <option value="Asia/Pontianak" {{ old('timezone') == 'Asia/Pontianak' ? 'selected' : '' }}>WIB - Pontianak (UTC+7)</option>
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Detail Information about Restaurant</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Describe your restaurant, specialties, atmosphere, etc.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mall Information -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_inside_mall" name="is_inside_mall" value="1"
                                   {{ old('is_inside_mall') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_inside_mall">
                                Restaurant is inside a mall
                            </label>
                        </div>
                    </div>

                    <div class="mall-fields mb-3">
                        <label for="mall_name" class="form-label">Mall Name (Full Name)</label>
                        <input type="text" class="form-control @error('mall_name') is-invalid @enderror"
                               id="mall_name" name="mall_name" value="{{ old('mall_name') }}"
                               placeholder="Enter the complete mall name (e.g., Grand Indonesia Mall)">
                        @error('mall_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Please enter the complete mall name without abbreviations</small>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Restaurant is active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Restaurant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    const defaultLat = -6.2088; // Jakarta coordinates
    const defaultLng = 106.8456;

    const map = L.map('map').setView([defaultLat, defaultLng], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    // Function to update marker
    function updateMarker(lat, lng) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map);
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }

    // Click on map to set coordinates
    map.on('click', function(e) {
        updateMarker(e.latlng.lat, e.latlng.lng);
    });

    // Update marker when inputs change
    document.getElementById('latitude').addEventListener('input', function() {
        const lat = parseFloat(this.value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMarker(lat, lng);
            map.setView([lat, lng], 15);
        }
    });

    document.getElementById('longitude').addEventListener('input', function() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            updateMarker(lat, lng);
            map.setView([lat, lng], 15);
        }
    });

    // Toggle mall fields
    document.getElementById('is_inside_mall').addEventListener('change', function() {
        const mallFields = document.querySelector('.mall-fields');
        if (this.checked) {
            mallFields.style.display = 'block';
        } else {
            mallFields.style.display = 'none';
            document.getElementById('mall_name').value = '';
        }
    });

    // Initialize mall fields visibility
    if (document.getElementById('is_inside_mall').checked) {
        document.querySelector('.mall-fields').style.display = 'block';
    }
});
</script>
@endsection