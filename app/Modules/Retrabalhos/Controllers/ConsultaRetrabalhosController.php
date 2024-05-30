<?php

namespace App\Modules\Retrabalhos\Controllers;

use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;

class ConsultaRetrabalhosController extends Controller
{
    use EquipeTools;
    public function __construct(
        private TipoRetrabalhoBusinessContract $tipoRetrabalhoBusiness
    )
    {

    }
    public function getTipos()
    {
        return response()->json($this->tipoRetrabalhoBusiness->listaTipoRetrabalho());
    }



}
