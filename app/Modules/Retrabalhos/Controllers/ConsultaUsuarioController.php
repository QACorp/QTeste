<?php

namespace App\Modules\Retrabalhos\Controllers;

use App\Modules\Retrabalhos\Contracts\Business\UserBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;

class ConsultaUsuarioController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {

    }
    public function getUsuarios()
    {
        return response()->json($this->userBusiness->listaUsuariosByPermissaoDesenvolvedor());
    }



}
