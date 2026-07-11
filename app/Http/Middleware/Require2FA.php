<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Require2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && empty($user->two_factor_secret)) {
            // Check if the route is not the 2FA setup route or Fortify's internal routes to avoid infinite redirects
            $allowedRoutes = [
                'admin.settings.2fa',
                'two-factor.enable',
                'two-factor.disable',
                'two-factor.qr-code',
                'two-factor.secret-key',
                'two-factor.recovery-codes',
                'two-factor.confirm',
                'admin.logout', // allow logout
                'logout'
            ];

            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('admin.settings.2fa')
                    ->with('warning', 'Please enable Two-Factor Authentication to access the admin dashboard.');
            }
        }

        return $next($request);
    }
}
