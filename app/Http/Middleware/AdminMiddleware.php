<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Check if user has access to admin panel
        $user = Auth::user();
        if (method_exists($user, 'canAccessAdminPanel') && !$user->canAccessAdminPanel()) {
             abort(403, 'Unauthorized access to admin area.');
        } elseif (!method_exists($user, 'canAccessAdminPanel')) {
             // Fallback if method doesn't exist (should not happen with our User model)
             // Check generic property or abort
             if (!isset($user->role) || !in_array($user->role, ['admin', 'editor'])) {
                 abort(403, 'Unauthorized access to admin area.');
             }
        }

        return $next($request);
    }
}