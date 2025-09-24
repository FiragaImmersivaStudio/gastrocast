<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class EnsureEmailVerificationIfEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if email verification is enabled via system parameter
        $emailVerificationEnabled = $this->isEmailVerificationEnabled();
        
        if ($emailVerificationEnabled && Auth::check()) {
            // Use Laravel's built-in email verification middleware
            $verifyMiddleware = new EnsureEmailIsVerified();
            return $verifyMiddleware->handle($request, $next);
        }

        return $next($request);
    }

    /**
     * Check if email verification is enabled via system parameters
     */
    private function isEmailVerificationEnabled(): bool
    {
        // First check environment variable as fallback
        $envSetting = env('EMAIL_VERIFICATION_ENABLED', true);
        
        try {
            // Try to get from system_parameters table
            // This will be implemented when we create the SystemParameter model
            return (bool) $envSetting;
        } catch (\Exception $e) {
            // Fallback to environment variable if database is not available
            return (bool) $envSetting;
        }
    }
}
