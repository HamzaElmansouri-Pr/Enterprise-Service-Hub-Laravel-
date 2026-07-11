<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('X-App-Locale') ?: $request->header('Accept-Language');

        // Extract primary language if it's an Accept-Language string like "fr-CH, fr;q=0.9, en;q=0.8, de;q=0.7, *;q=0.5"
        if ($locale && strpos($locale, ',') !== false) {
            $locale = explode(',', $locale)[0];
        }
        if ($locale && strpos($locale, '-') !== false) {
            $locale = explode('-', $locale)[0];
        }

        $supportedLocales = ['en', 'fr', 'ar'];

        if ($locale && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('en'); // Default fallback
        }

        return $next($request);
    }
}
