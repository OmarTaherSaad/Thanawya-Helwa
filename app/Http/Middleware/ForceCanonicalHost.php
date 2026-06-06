<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301 redirect to the host (and scheme) from APP_URL when the request uses a different host.
 * Fixes duplicate content between www and apex when APP_URL matches the chosen canonical host.
 */
class ForceCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->shouldRedirect($request)) {
            return $next($request);
        }

        $appUrl = rtrim((string) config('app.url'), '/');
        $target = $appUrl.$request->getRequestUri();

        return redirect()->to($target, Response::HTTP_MOVED_PERMANENTLY);
    }

    private function shouldRedirect(Request $request): bool
    {
        if (! config('seo.canonical_host_redirect')) {
            return false;
        }

        $appUrl = (string) config('app.url', '');
        $canonicalHost = parse_url($appUrl, PHP_URL_HOST);
        if (! is_string($canonicalHost) || $canonicalHost === '') {
            return false;
        }

        $requestHost = $request->getHost();

        return strcasecmp($requestHost, $canonicalHost) !== 0;
    }
}
