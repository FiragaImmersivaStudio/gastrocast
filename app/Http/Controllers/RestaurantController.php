<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get restaurants where user is owner OR is attached as a user
        $restaurants = Restaurant::where(function($query) use ($user) {
            $query->where('owner_user_id', $user->id)
                  ->orWhereHas('users', function($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        })->with(['owner', 'users'])->paginate(10);
        
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'is_inside_mall' => 'boolean',
            'mall_name' => 'nullable|string|max:255',
            'timezone' => 'required|string|max:50|in:' . implode(',', $this->getIndonesianTimezones()),
        ]);

        $restaurant = Restaurant::create([
            'owner_user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
            'is_inside_mall' => $request->boolean('is_inside_mall'),
            'mall_name' => $request->mall_name,
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
        
        $restaurant->load(['users', 'owner']);
        
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'is_inside_mall' => 'boolean',
            'mall_name' => 'nullable|string|max:255',
            'timezone' => 'required|string|max:50|in:' . implode(',', $this->getIndonesianTimezones()),
        ]);

        $restaurant->update($request->only([
            'name', 'category', 'address', 'latitude', 'longitude', 'phone', 'email', 'website', 'description', 'is_inside_mall', 'mall_name', 'timezone'
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

    /**
     * Invite a user to the restaurant
     */
    public function inviteUser(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:manager,staff'
        ]);

        // Find the user by email
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->with('error', 'User with this email not found.');
        }

        // Check if user is already associated with this restaurant
        if ($restaurant->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()
                ->with('error', 'User is already associated with this restaurant.');
        }

        // Add user to restaurant
        $restaurant->users()->attach($user->id, [
            'role' => $request->role,
            'joined_at' => now()
        ]);

        return redirect()->back()
            ->with('success', "User '{$user->name}' has been invited to '{$restaurant->name}' as {$request->role}.");
    }

    /**
     * Remove a user from the restaurant
     */
    public function removeUser(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = \App\Models\User::find($request->user_id);
        
        // Check if user is associated with this restaurant
        if (!$restaurant->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()
                ->with('error', 'User is not associated with this restaurant.');
        }

        // Remove user from restaurant
        $restaurant->users()->detach($user->id);

        return redirect()->back()
            ->with('success', "User '{$user->name}' has been removed from '{$restaurant->name}'.");
    }

    /**
     * Check if user exists by email (AJAX endpoint)
     */
    public function checkUserExists(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['exists' => false, 'message' => 'Email is required']);
        }

        $user = \App\Models\User::where('email', $email)->first();
        
        if ($user) {
            return response()->json([
                'exists' => true, 
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        }

        return response()->json(['exists' => false, 'message' => 'User not found']);
    }

    /**
     * Invite a user to the restaurant (AJAX endpoint)
     */
    public function inviteUserAjax(Request $request, Restaurant $restaurant)
    {
        try {
            $this->authorize('update', $restaurant);

            $request->validate([
                'email' => 'required|email|exists:users,email',
                'role' => 'required|in:manager,staff'
            ]);

            // Find the user by email
            $user = \App\Models\User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User with this email not found.'
                ], 404);
            }

            // Check if user is the owner
            if ($user->id === $restaurant->owner_user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'The restaurant owner cannot be invited as a team member.'
                ], 422);
            }

            // Check if user is already associated with this restaurant
            if ($restaurant->users()->where('user_id', $user->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already associated with this restaurant.'
                ], 422);
            }

            // Add user to restaurant
            $restaurant->users()->attach($user->id, [
                'role' => $request->role,
                'joined_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => "User '{$user->name}' has been invited to '{$restaurant->name}' as {$request->role}.",
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $request->role,
                    'joined_at' => now()->format('M j, Y')
                ]
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to invite users to this restaurant.'
            ], 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error inviting user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }

    /**
     * Get Indonesian timezone options
     */
    private function getIndonesianTimezones()
    {
        return [
            'Asia/Jakarta',
            'Asia/Makassar',
            'Asia/Jayapura',
            'Asia/Pontianak',
        ];
    }
}