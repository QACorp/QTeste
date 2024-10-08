<?php

namespace App\System\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use const http\Client\Curl\AUTH_ANY;

class EquipeUtils
{

    public static function equipeUsuarioLogado(string $guard = 'web'):?int
    {
        $equipeUsuarioLogado = self::getEquipeUsuarioLogado($guard);
        if(!$equipeUsuarioLogado) {
            redirect()->route('users.index')->send();
        }
        return $equipeUsuarioLogado;

    }
    public static function getEquipeUsuarioLogado(string $guard = 'web'): ?int
    {
        if(Auth::guard($guard)->user()->selected_equipe_id != null) {
            return Auth::guard($guard)->user()->selected_equipe_id;
        }else{
            if(Auth::guard($guard)->user()->equipes->get(0) != null) {
                return Auth::guard($guard)->user()->equipes->get(0)->id;
            }else {
                return null;
            }
        }
    }
}
