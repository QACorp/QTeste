<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Controllers;

use App\System\Http\Controllers\Controller;

class AlocacaoController extends Controller
{
    public function index()
    {
        return view('alocacao::index');
    }
}
