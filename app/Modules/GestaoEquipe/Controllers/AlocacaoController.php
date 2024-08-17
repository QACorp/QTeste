<?php

namespace App\Modules\GestaoEquipe\Controllers;

use App\System\Http\Controllers\Controller;

class AlocacaoController extends Controller
{
    public function index()
    {
        return view('gestao-equipe::index');
    }
}
