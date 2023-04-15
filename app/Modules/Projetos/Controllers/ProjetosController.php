<?php

namespace App\Modules\Projetos\Controllers;

use App\System\Http\Controllers\Controller;

class ProjetosController extends Controller
{
    public function index(int $id)
    {
        return view('projetos::projetos.home');
    }
}
