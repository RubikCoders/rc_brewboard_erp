<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LandingPageMiddleware
{
    /**
     * Handle an incoming request for landing pages
     * Provides security, analytics, and performance optimizations
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Add security headers for landing pages
        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Performance Headers
        $response->headers->set('Cache-Control', 'public, max-age=3600'); // 1 hour cache for landing pages

        // Add canonical URL for SEO
        if (!$response->headers->has('Link')) {
            $canonicalUrl = $request->url();
            $response->headers->set('Link', "<{$canonicalUrl}>; rel=\"canonical\"");
        }

        // Add structured data headers
        $response->headers->set('X-Robots-Tag', 'index, follow, max-snippet:-1, max-image-preview:large');

        // Track page view (could integrate with analytics service)
        $this->trackPageView($request);

        return $response;
    }

    /**
     * Track page view for analytics
     * 
     * @param Request $request
     * @return void
     */
    private function trackPageView(Request $request): void
    {
        // Log page view for internal analytics
        \Log::info('Landing page view', [
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'ip' => $request->ip(),
            'timestamp' => now()
        ]);

        // Here you could integrate with external analytics services:
        // - Google Analytics Measurement Protocol
        // - Mixpanel
        // - Custom analytics database
    }
}