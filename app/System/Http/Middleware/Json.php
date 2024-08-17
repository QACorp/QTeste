<?php

namespace App\System\Http\Middleware;



use Closure;

class Json
{
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
