<?php

namespace App\Modules\GestaoEquipe\Controllers;

use App\System\Http\Controllers\Controller;

class GestaoEquipeController extends Controller
{
    public function dashboard(int $idUsuario)
    {
        return view('gestao-equipe::dashboard', ['idUsuario' => $idUsuario]);
    }
}
