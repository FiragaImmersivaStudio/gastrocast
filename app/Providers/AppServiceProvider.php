<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share restaurants with layout when user is authenticated
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                try {
                    // Get restaurants from both owned and accessible via many-to-many
                    $ownedRestaurants = Auth::user()->ownedRestaurants()
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                    
                    $accessibleRestaurants = Auth::user()->restaurants()
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                    
                    // Merge and remove duplicates
                    $restaurants = $ownedRestaurants->merge($accessibleRestaurants)->unique('id');
                    
                    $selectedRestaurantId = session('selected_restaurant_id');
                    $selectedRestaurant = null;
                    
                    if ($selectedRestaurantId && $restaurants->count() > 0) {
                        $selectedRestaurant = $restaurants->firstWhere('id', $selectedRestaurantId);
                        
                        // If selected restaurant is not found in user's accessible restaurants, clear session
                        if (!$selectedRestaurant) {
                            session()->forget(['selected_restaurant_id', 'active_restaurant_name']);
                        }
                    }
                    
                    $view->with([
                        'userRestaurants' => $restaurants,
                        'selectedRestaurant' => $selectedRestaurant
                    ]);
                } catch (\Exception $e) {
                    // In case of any errors, provide empty collections
                    $view->with([
                        'userRestaurants' => collect(),
                        'selectedRestaurant' => null
                    ]);
                }
            }
        });
    }
}
