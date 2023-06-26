<?php

namespace App\System\Traits;

use Illuminate\Support\Facades\Auth;

trait Authverification
{
    private function userMembroEquipe(int $equipeId):bool
    {

        return Auth::user()->equipes()->where('id', $equipeId)->first() != null;
    }
}
