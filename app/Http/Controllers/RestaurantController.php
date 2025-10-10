<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants
     */
    public function index()
    {
        $restaurants = Auth::user()->restaurants()->with('owner')->paginate(10);
        
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new restaurant
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created restaurant in storage
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

        $restaurant->users()->attach(Auth::id());

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant created successfully.');
    }

    /**
     * Display the specified restaurant
     */
    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified restaurant
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified restaurant in storage
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

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant updated successfully.');
    }

    /**
     * Remove the specified restaurant from storage
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        
        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('success', 'Restaurant deleted successfully.');
    }

    /**
     * Select a restaurant as the current active restaurant
     */
    public function select(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        
        // Check if restaurant is active
        if (!$restaurant->is_active) {
            return redirect()->back()
                ->with('error', 'Cannot select an inactive restaurant.');
        }
        
        // Store the selected restaurant in session
        session([
            'selected_restaurant_id' => $restaurant->id,
            'active_restaurant_name' => $restaurant->name
        ]);

        return redirect()->back()
            ->with('success', "Restaurant '{$restaurant->name}' selected successfully.");
    }

    /**
     * Deselect the current active restaurant
     */
    public function deselect()
    {
        $currentRestaurantName = session('active_restaurant_name', 'restaurant');
        
        session()->forget(['selected_restaurant_id', 'active_restaurant_name']);

        return redirect()->back()
            ->with('success', "Restaurant '{$currentRestaurantName}' deselected successfully.");
    }
}