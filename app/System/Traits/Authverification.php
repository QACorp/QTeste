<?php

namespace App\System\Traits;

use Illuminate\Http\Request;
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
}
