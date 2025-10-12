<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use PragmaRX\Google2FA\Google2FA;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $selectedRestaurant = null;
        
        // Get selected restaurant from session
        if (session('selected_restaurant_id')) {
            $selectedRestaurant = Restaurant::find(session('selected_restaurant_id'));
        }
        
        // Get user's invoices for billing history
        $invoices = $user->invoices()->orderBy('created_at', 'desc')->limit(10)->get();
        
        return view('settings.index', compact('user', 'selectedRestaurant', 'invoices'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'timezone' => 'required|string',
            ]);
            
            $fullName = trim($request->first_name . ' ' . ($request->last_name ?? ''));
            
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $fullName,
                'email' => $request->email,
                'phone' => $request->phone,
                'timezone' => $request->timezone,
            ]);
            
            Log::info('Profile updated for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRestaurant(Request $request)
    {
        try {
            $selectedRestaurantId = session('selected_restaurant_id');
            
            if (!$selectedRestaurantId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No restaurant selected. Please select a restaurant first.'
                ], 400);
            }
            
            $restaurant = Restaurant::findOrFail($selectedRestaurantId);
            
            // Check if user has permission to edit this restaurant
            if (!Auth::user()->hasAccessToRestaurant($restaurant->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to edit this restaurant.'
                ], 403);
            }
            
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string',
                'currency' => 'required|string|max:3',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email',
            ]);
            
            $restaurant->update([
                'name' => $request->name,
                'category' => $request->category,
                'currency' => $request->currency,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            
            Log::info('Restaurant updated: ' . $restaurant->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Restaurant settings updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Restaurant update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateNotifications(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validated = $request->validate([
                'forecast_ready' => 'sometimes|in:on',
                'system_updates' => 'sometimes|in:on',
                'forecast_next_month' => 'sometimes|in:on',
            ]);
            
            $user->update([
                'notification_forecast_ready' => $request->input('forecast_ready') === 'on',
                'notification_system_updates' => $request->input('system_updates') === 'on',
                'notification_forecast_next_month' => $request->input('forecast_next_month') === 'on',
            ]);
            
            Log::info('Notifications updated for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Notification preferences updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Notifications update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => ['required', 'confirmed', Password::min(6)],
            ]);
            
            $user = Auth::user();
            
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }
            
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            Log::info('Password changed for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Password change error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enable2FA(Request $request)
    {
        try {
            $user = Auth::user();
            $google2fa = new Google2FA();
            
            // Generate a secure secret
            $secret = $google2fa->generateSecretKey();
            
            // Create the company name and user details for QR code
            $companyName = config('app.name', 'GastroCast');
            $companyEmail = $user->email;
            
            // Generate QR Code URL
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                $companyName,
                $companyEmail,
                $secret
            );
            
            // Generate QR Code using multiple third-party APIs as fallback
            $qrCodeApis = [
                // Primary: QR Server (fast and reliable)
                'qr_server' => 'https://api.qrserver.com/v1/create-qr-code/?' . http_build_query([
                    'size' => '200x200',
                    'data' => $qrCodeUrl,
                    'format' => 'png',
                    'bgcolor' => 'FFFFFF',
                    'color' => '000000',
                    'qzone' => '1',
                    'margin' => '10'
                ]),
                // Secondary: Chart.googleapis.com (Google's service)
                'google_chart' => 'https://chart.googleapis.com/chart?' . http_build_query([
                    'chs' => '200x200',
                    'cht' => 'qr',
                    'chl' => $qrCodeUrl,
                    'choe' => 'UTF-8'
                ]),
                // Tertiary: QuickChart.io 
                'quickchart' => 'https://quickchart.io/qr?' . http_build_query([
                    'text' => $qrCodeUrl,
                    'size' => '200x200',
                    'margin' => '10'
                ])
            ];
            
            $user->update([
                'two_factor_secret' => $secret,
                'two_factor_enabled' => false, // Will be enabled after verification
            ]);
            
            Log::info('2FA setup initiated for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'secret' => $secret,
                'qr_code_url' => $qrCodeUrl,
                'qr_code_apis' => $qrCodeApis,
                'backup_codes' => $this->generateBackupCodes(),
                'message' => '2FA setup initiated. Please scan the QR code with your authenticator app.'
            ]);
        } catch (\Exception $e) {
            Log::error('2FA enable error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verify2FA(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|size:6',
            ]);
            
            $user = Auth::user();
            $google2fa = new Google2FA();
            
            // Verify the code using Google2FA
            $isValid = $google2fa->verifyKey($user->two_factor_secret, $request->code);
            
            if ($isValid) {
                $user->update(['two_factor_enabled' => true]);
                
                Log::info('2FA enabled successfully for user: ' . $user->id);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Two-factor authentication has been enabled successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification code. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('2FA verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate backup codes for 2FA
     */
    private function generateBackupCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        }
        return $codes;
    }

    public function disable2FA(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
            ]);
            
            $user = Auth::user();
            
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is incorrect'
                ], 400);
            }
            
            $user->update([
                'two_factor_secret' => null,
                'two_factor_enabled' => false,
            ]);
            
            Log::info('2FA disabled for user: ' . $user->id);
            
            return response()->json([
                'success' => true,
                'message' => '2FA disabled successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('2FA disable error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'confirmation' => 'required|in:DELETE',
            ]);
            
            $user = Auth::user();
            
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is incorrect'
                ], 400);
            }
            
            // Soft delete the user
            $user->update([
                'deleted_at' => now(),
                'deletion_requested_at' => now(),
            ]);
            
            Log::info('Account deletion requested for user: ' . $user->id);
            
            // Log out the user
            Auth::logout();
            
            return response()->json([
                'success' => true,
                'message' => 'Account deletion requested. Your account will be permanently deleted in 31 days.',
                'redirect' => route('login')
            ]);
        } catch (\Exception $e) {
            Log::error('Delete account error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}