<?php

namespace App\System\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait Authverification
{
    private function userMembroEquipe(int $equipeId, string $guard = 'web'):bool
    {

        return Auth::guard($guard)->user()->equipes()->where('id', $equipeId)->first() != null;
    }

    private function loginApi(Request $request):?string
    {
        $remember = $request->has('remember') ? $request->boolean('remember') : false;
//        dd(auth('api')->attempt([...$request->only('email', 'password'), 'active' => true], $remember), $remember);
        return auth('api')->setTTL($remember ? 525600 : config('jwt.ttl'))->attempt([...$request->only('email', 'password'), 'active' => true]);

    }
    protected function getToken($token): \stdClass
    {
        return (object)[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'created_at' => Carbon::now()
        ];
    }
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
