<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ScopeTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $activeRestaurantId = session('active_restaurant_id');
            
            // If no active restaurant is set, try to set the first restaurant the user owns/has access to
            if (!$activeRestaurantId && $user->restaurants()->exists()) {
                $firstRestaurant = $user->restaurants()->first();
                session(['active_restaurant_id' => $firstRestaurant->id]);
                $activeRestaurantId = $firstRestaurant->id;
            }
            
            // Set the active restaurant ID globally for the request
            if ($activeRestaurantId) {
                config(['app.active_restaurant_id' => $activeRestaurantId]);
                
                // Add global scope to models that should be tenant-scoped
                $this->applyTenantScopes($activeRestaurantId);
            }
        }

        return $next($request);
    }

    /**
     * Apply tenant scopes to relevant models
     */
    private function applyTenantScopes($restaurantId)
    {
        // This will be implemented when we create the models
        // For now, we'll add this as a reminder
    }
}
