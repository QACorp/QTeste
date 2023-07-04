<?php

namespace App\System\Utils;

use Illuminate\Support\Facades\Cookie;

class EquipeUtils
{
    public static function equipeUsuarioLogado():int{
        return Cookie::get(config('app.cookie_equipe_nome'));
    }
}
