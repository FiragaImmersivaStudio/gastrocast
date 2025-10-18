# Restaurant Selector Implementation

## Overview
The restaurant selector has been implemented with the following features:

## Features Implemented

### 1. **Dynamic Restaurant Selection**
- Restaurant dropdown now dynamically loads user's restaurants
- Shows both owned restaurants and restaurants with access permissions
- Only shows active restaurants

### 2. **Visual Indicators**
- **Active Restaurant**: When a restaurant is selected, it shows:
  - A pulsing green dot indicator next to the restaurant name
  - Yellow-tinted background on the selector button
  - Checkmark next to the selected restaurant in the dropdown

### 3. **Session Management**
- Selected restaurant is stored in session (`selected_restaurant_id`, `active_restaurant_name`)
- Session persists across page loads
- Automatic cleanup if selected restaurant becomes inaccessible

### 4. **Navigation Links**
- **Add Restaurant**: Clicking "Add Restaurant" redirects to `/restaurants/create`
- **Deselect Restaurant**: Option to deselect current restaurant appears when one is active

### 5. **Authorization**
- Full authorization system implemented via `RestaurantPolicy`
- Users can only select restaurants they own or have access to
- Proper authorization checks on all restaurant operations

## Routes Added
```php
POST /restaurants/{restaurant}/select    # Select a restaurant
POST /restaurants/deselect              # Deselect current restaurant
```

## Helper Functions
Three global helper functions have been added:

```php
selected_restaurant()      // Returns current Restaurant model or null
has_selected_restaurant()  // Returns boolean if restaurant is selected
selected_restaurant_id()   // Returns current restaurant ID or null
```

## Usage Examples

### In Controllers
```php
public function index() {
    if (has_selected_restaurant()) {
        $restaurant = selected_restaurant();
        // Filter data by selected restaurant
        $orders = $restaurant->orders()->get();
    }
}
```

### In Views
```blade
@if(has_selected_restaurant())
    <h3>Data for: {{ selected_restaurant()->name }}</h3>
@else
    <div class="alert alert-info">Please select a restaurant to view data</div>
@endif
```

## Technical Implementation

### 1. **View Composer**
- `AppServiceProvider` shares restaurant data with `layouts.app`
- Automatically loads user's restaurants and selected restaurant
- Handles edge cases and errors gracefully

### 2. **Controller Methods**
- `RestaurantController@select`: Handles restaurant selection
- `RestaurantController@deselect`: Handles restaurant deselection
- Proper flash messages for user feedback

### 3. **Authorization Policy**
- `RestaurantPolicy` class handles all restaurant permissions
- Checks ownership and access rights
- Registered in `AuthServiceProvider`

### 4. **Frontend Enhancements**
- Bootstrap dropdown with form submissions
- Loading states with JavaScript
- Responsive design with visual feedback
- Auto-disable buttons during submission

## Flash Messages
The system provides user feedback:
- ✅ Success: "Restaurant 'Name' selected successfully"
- ✅ Success: "Restaurant 'Name' deselected successfully"
- ❌ Error: "Cannot select an inactive restaurant"

## Error Handling
- Graceful handling of missing restaurants
- Automatic session cleanup for invalid selections
- Authorization failures properly handled
- Database errors contained with try-catch blocks

The restaurant selector is now fully functional and integrated into the application header!