<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Auto-select default restaurant if set
            $user = Auth::user();
            if ($user->default_restaurant_id) {
                $defaultRestaurant = \App\Models\Restaurant::find($user->default_restaurant_id);
                if ($defaultRestaurant && $defaultRestaurant->is_active) {
                    // Check if user has access to this restaurant
                    $hasAccess = \App\Models\Restaurant::where('id', $defaultRestaurant->id)
                        ->where(function($query) use ($user) {
                            $query->where('owner_user_id', $user->id)
                                  ->orWhereHas('users', function($q) use ($user) {
                                      $q->where('user_id', $user->id);
                                  });
                        })->exists();

                    if ($hasAccess) {
                        session([
                            'selected_restaurant_id' => $defaultRestaurant->id,
                            'active_restaurant_name' => $defaultRestaurant->name
                        ]);
                    }
                }
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
