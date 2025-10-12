@extends('layouts.app')

@section('title', 'Edit ' . $restaurant->name . '')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Restaurant</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('restaurants.update', $restaurant) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Restaurant Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $restaurant->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category">
                                    <option value="">Select a category</option>
                                    <option value="Fast Food" {{ old('category', $restaurant->category) == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                                    <option value="Fine Dining" {{ old('category', $restaurant->category) == 'Fine Dining' ? 'selected' : '' }}>Fine Dining</option>
                                    <option value="Casual Dining" {{ old('category', $restaurant->category) == 'Casual Dining' ? 'selected' : '' }}>Casual Dining</option>
                                    <option value="Cafe" {{ old('category', $restaurant->category) == 'Cafe' ? 'selected' : '' }}>Cafe</option>
                                    <option value="Pizza" {{ old('category', $restaurant->category) == 'Pizza' ? 'selected' : '' }}>Pizza</option>
                                    <option value="Asian" {{ old('category', $restaurant->category) == 'Asian' ? 'selected' : '' }}>Asian</option>
                                    <option value="Mexican" {{ old('category', $restaurant->category) == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                                    <option value="Italian" {{ old('category', $restaurant->category) == 'Italian' ? 'selected' : '' }}>Italian</option>
                                    <option value="Bakery" {{ old('category', $restaurant->category) == 'Bakery' ? 'selected' : '' }}>Bakery</option>
                                    <option value="Other" {{ old('category', $restaurant->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $restaurant->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $restaurant->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $restaurant->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="timezone" class="form-label">Timezone *</label>
                        <select class="form-select @error('timezone') is-invalid @enderror" 
                                id="timezone" name="timezone" required>
                            <option value="">Select timezone</option>
                            <option value="UTC" {{ old('timezone', $restaurant->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                            <option value="America/New_York" {{ old('timezone', $restaurant->timezone) == 'America/New_York' ? 'selected' : '' }}>Eastern Time (ET)</option>
                            <option value="America/Chicago" {{ old('timezone', $restaurant->timezone) == 'America/Chicago' ? 'selected' : '' }}>Central Time (CT)</option>
                            <option value="America/Denver" {{ old('timezone', $restaurant->timezone) == 'America/Denver' ? 'selected' : '' }}>Mountain Time (MT)</option>
                            <option value="America/Los_Angeles" {{ old('timezone', $restaurant->timezone) == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (PT)</option>
                            <option value="Europe/London" {{ old('timezone', $restaurant->timezone) == 'Europe/London' ? 'selected' : '' }}>London (GMT)</option>
                            <option value="Europe/Paris" {{ old('timezone', $restaurant->timezone) == 'Europe/Paris' ? 'selected' : '' }}>Paris (CET)</option>
                            <option value="Asia/Tokyo" {{ old('timezone', $restaurant->timezone) == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo (JST)</option>
                            <option value="Asia/Jakarta" {{ old('timezone', $restaurant->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>Jakarta (WIB)</option>
                        </select>
                        @error('timezone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                   {{ old('is_active', $restaurant->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Restaurant is active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Restaurant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection