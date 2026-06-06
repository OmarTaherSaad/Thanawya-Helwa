<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Drops headers that add little value for SEO/security hygiene (e.g. X-Powered-By).
 * For full removal of X-Powered-By from PHP itself, also set expose_php=Off in php.ini.
 */
class RemoveUnwantedResponseHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
