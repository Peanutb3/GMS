<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and add security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection in older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Disable dangerous browser features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content Security Policy (adjust as needed for your app)
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://www.svgrepo.com; " .
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com; " .
                "font-src 'self' https://fonts.gstatic.com; " .
                "img-src 'self' data: https://www.svgrepo.com; " .
                "connect-src 'self';"
        );

        return $response;
    }
}
