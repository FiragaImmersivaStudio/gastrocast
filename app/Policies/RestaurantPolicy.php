<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any restaurants.
     */
    public function viewAny(User $user)
    {
        return true; // Users can view their own restaurants
    }

    /**
     * Determine whether the user can view the restaurant.
     */
    public function view(User $user, Restaurant $restaurant)
    {
        // User can view if they own it or have access through the pivot table
        return $restaurant->owner_user_id === $user->id 
            || $user->hasAccessToRestaurant($restaurant->id);
    }

    /**
     * Determine whether the user can create restaurants.
     */
    public function create(User $user)
    {
        return true; // All authenticated users can create restaurants
    }

    /**
     * Determine whether the user can update the restaurant.
     */
    public function update(User $user, Restaurant $restaurant)
    {
        // Only owner can update
        return $restaurant->owner_user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the restaurant.
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        // Only owner can delete
        return $restaurant->owner_user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the restaurant.
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        return $restaurant->owner_user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the restaurant.
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        return $restaurant->owner_user_id === $user->id;
    }
}