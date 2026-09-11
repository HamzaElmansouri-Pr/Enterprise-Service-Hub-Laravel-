<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Standard Security Headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        
        $nonce = \Illuminate\Support\Str::random(32);
        \Illuminate\Support\Facades\View::share('cspNonce', $nonce);
        \Illuminate\Support\Facades\Vite::useCspNonce($nonce);

        $isLocal = app()->environment('local', 'testing');
        $isAdmin = $request->is('admin/*') || $request->is('admin');

        // Admin pages use inline event handlers (onclick, oninput, etc.)
        // which are incompatible with nonce-based CSP (nonce causes 'unsafe-inline' to be ignored).
        // For admin routes (auth-protected), we use 'unsafe-inline' without a nonce.
        if ($isAdmin) {
            $scriptSrc = "'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.tailwindcss.com https://cdn.tiny.cloud";
        } else {
            $scriptSrc = "'self' 'unsafe-inline' 'nonce-{$nonce}' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://cdn.tailwindcss.com https://cdn.tiny.cloud";
        }

        $styleSrc = "'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.datatables.net https://cdn.tiny.cloud";
        $fontSrc = "'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com";
        $imgSrc = "'self' data: blob: https://res.cloudinary.com https://images.unsplash.com https://i.pravatar.cc https://sp.tinymce.com";
        $connectSrc = "'self' https://cdn.tailwindcss.com https://cdn.jsdelivr.net";

        if ($isLocal) {
            if (!$isAdmin) {
                $scriptSrc .= " 'unsafe-eval'";
            }
            $scriptSrc .= " http://localhost:5173";
            $styleSrc .= " http://localhost:5173";
            $imgSrc .= " http://localhost:5173 http://localhost:8000 http://127.0.0.1:8000";
            $connectSrc .= " http://localhost:5173 ws://localhost:5173 wss://localhost:5173 ws://127.0.0.1:8080 wss://127.0.0.1:8080 ws://localhost:8080 wss://localhost:8080";
        } else {
            // Production only: Enforce HTTPS
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $csp = "default-src 'self'; "
             . "script-src {$scriptSrc}; "
             . "style-src {$styleSrc}; "
             . "font-src {$fontSrc}; "
             . "img-src {$imgSrc}; "
             . "connect-src {$connectSrc};";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
