<?php

namespace App\System\Http\Middleware;



use App\System\Utils\VueHandler;
use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

class Vue
{
    public function handle($request, Closure $next)
    {
        App::singleton(VueHandler::class, function (Application $app) {
            return new VueHandler(true);
        });

        return $next($request);
    }
}
