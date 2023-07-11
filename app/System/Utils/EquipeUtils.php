<?php

namespace App\System\Utils;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use const http\Client\Curl\AUTH_ANY;

class EquipeUtils
{
    public static function equipeUsuarioLogado():int{
        if(Auth::user()->selected_equipe_id != null)
            return Auth::user()->selected_equipe_id;
        else
            return Auth::user()->equipes->get(0)->id;
    }
}
