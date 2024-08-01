<?php

namespace App\System\Http\Middleware;

use App\System\Enums\AuthEnum;
use App\System\Traits\Authverification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class ManagerApiTokenSession
{
    use Authverification;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiTokenSession = unserialize($request->session()->get(AuthEnum::SESSION_API_TOKEN->value));
        if($apiTokenSession){
            $dueDateRemaning = $apiTokenSession->expires_in - Carbon::now()->diffInSeconds($apiTokenSession->created_at);

            if($dueDateRemaning < 20 ){
                Auth::guard('api')->setToken($apiTokenSession->access_token);
                if(Auth::guard('api')->check()){
                    Auth::guard('api')->invalidate(true);
                }
                $newToken = Auth::guard('api')->fromUser(Auth::user());
                $request->session()->put(AuthEnum::SESSION_API_TOKEN->value,serialize($this->getToken($newToken)));

            }
        }
        return $next($request);
    }
}
