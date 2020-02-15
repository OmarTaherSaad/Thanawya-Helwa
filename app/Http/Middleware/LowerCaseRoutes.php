<?php

namespace App\Http\Middleware;

use Closure;

class LowerCaseRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!ctype_lower(preg_replace('/[^A-Za-z]/', '', $request->path())) && $request->path() !== "/" && $request->method() == 'GET') {
            $new_route = str_replace($request->path(), strtolower($request->path()), $request->fullUrl());
            return redirect()->to($new_route, 301);
        }
        return $next($request);

    }
}
