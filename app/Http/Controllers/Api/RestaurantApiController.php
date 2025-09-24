<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantApiController extends Controller
{
    /**
     * Display a listing of restaurants
     */
    public function index()
    {
        $restaurants = Auth::user()->restaurants()
            ->with('owner')
            ->get();

        return response()->json([
            'data' => $restaurants,
            'message' => 'Restaurants retrieved successfully'
        ]);
    }

    /**
     * Store a newly created restaurant
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'timezone' => 'required|string|max:50',
        ]);

        $restaurant = Restaurant::create([
            'owner_user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'timezone' => $request->timezone,
            'is_active' => true,
        ]);

        return response()->json([
            'data' => $restaurant->load('owner'),
            'message' => 'Restaurant created successfully'
        ], 201);
    }

    /**
     * Update the specified restaurant
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'timezone' => 'required|string|max:50',
        ]);

        $restaurant->update($request->only([
            'name', 'category', 'address', 'phone', 'email', 'timezone'
        ]));

        return response()->json([
            'data' => $restaurant->load('owner'),
            'message' => 'Restaurant updated successfully'
        ]);
    }

    /**
     * Remove the specified restaurant
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        
        $restaurant->delete();

        return response()->json([
            'message' => 'Restaurant deleted successfully'
        ]);
    }

    /**
     * Select a restaurant as the current active restaurant
     */
    public function select(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        // Store the selected restaurant in session
        session([
            'selected_restaurant_id' => $restaurant->id,
            'active_restaurant_name' => $restaurant->name
        ]);

        return response()->json([
            'data' => $restaurant,
            'message' => 'Restaurant selected successfully'
        ]);
    }
}