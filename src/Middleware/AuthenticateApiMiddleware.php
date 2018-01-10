<?php

namespace Yansongda\LaravelApi\Middleware;

use Closure;

class AuthenticateApiMiddleware
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
        // coding...

        return $next($request);
    }
}