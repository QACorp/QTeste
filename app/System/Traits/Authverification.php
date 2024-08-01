<?php

namespace App\System\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait Authverification
{
    private function userMembroEquipe(int $equipeId):bool
    {

        return Auth::user()->equipes()->where('id', $equipeId)->first() != null;
    }

    private function loginApi(Request $request):?string
    {
        $credentials = $request->only('email', 'password');
        return auth('api')->attempt([...$request->only('email', 'password'), 'active' => true]);

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
