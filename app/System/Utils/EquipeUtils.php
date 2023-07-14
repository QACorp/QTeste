<?php

namespace App\System\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use const http\Client\Curl\AUTH_ANY;

class EquipeUtils
{
    public static function equipeUsuarioLogado():?int{
        if(Auth::user()->selected_equipe_id != null) {
            return Auth::user()->selected_equipe_id;
        }else{
            if(Auth::user()->equipes->get(0) != null) {
                return Auth::user()->equipes->get(0)->id;
            }else {
                redirect()->route('users.index')->send();

            }
        }

    }
}
