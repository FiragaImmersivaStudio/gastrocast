<?php

if (!function_exists('selected_restaurant')) {
    /**
     * Get the currently selected restaurant from session
     * 
     * @return \App\Models\Restaurant|null
     */
    function selected_restaurant()
    {
        $restaurantId = session('selected_restaurant_id');
        
        if (!$restaurantId) {
            return null;
        }
        
        try {
            return \App\Models\Restaurant::find($restaurantId);
        } catch (\Exception $e) {
            // Clear invalid session data
            session()->forget(['selected_restaurant_id', 'active_restaurant_name']);
            return null;
        }
    }
}

if (!function_exists('has_selected_restaurant')) {
    /**
     * Check if there is a currently selected restaurant
     * 
     * @return bool
     */
    function has_selected_restaurant()
    {
        return session()->has('selected_restaurant_id') && !is_null(selected_restaurant());
    }
}

if (!function_exists('selected_restaurant_id')) {
    /**
     * Get the currently selected restaurant ID
     * 
     * @return int|null
     */
    function selected_restaurant_id()
    {
        return session('selected_restaurant_id');
    }
}