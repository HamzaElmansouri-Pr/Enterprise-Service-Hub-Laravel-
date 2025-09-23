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

        // Check if user has admin role (you can customize this logic)
        // For now, we'll allow any authenticated user to access admin
        // In production, you might want to add a role system
        $user = Auth::user();
        
        // You can add role checking here
        // if (!$user->hasRole('admin')) {
        //     abort(403, 'Unauthorized access to admin area.');
        // }

        return $next($request);
    }
}