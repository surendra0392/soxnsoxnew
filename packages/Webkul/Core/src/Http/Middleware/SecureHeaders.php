<?php

namespace Webkul\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * Unwanted header list to strip.
     *
     * @var array
     */
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders();

        $response = $next($request);

        $this->setHeaders($response, $request);

        return $response;
    }

    /**
     * Set production security headers.
     *
     * @param  Response  $response
     * @param  Request  $request
     * @return void
     */
    private function setHeaders($response, $request)
    {
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        $host = (string) $request->getHost();
        $isLocalHost = in_array($host, ['localhost', '127.0.0.1'], true) || str_ends_with($host, '.test');

        if (! $isLocalHost && (str_starts_with((string) config('app.url'), 'https://') || $request->isSecure() || $request->header('X-Forwarded-Proto') === 'https')) {
            $response->headers->set('Content-Security-Policy', 'upgrade-insecure-requests');
        }
    }

    /**
     * Remove unwanted headers.
     *
     * @return void
     */
    private function removeUnwantedHeaders()
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->unwantedHeaderList as $header) {
            header_remove($header);
        }
    }
}
