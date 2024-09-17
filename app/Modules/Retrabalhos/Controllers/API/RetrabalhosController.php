<?php

namespace App\Modules\Retrabalhos\Controllers\API;

use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDTO;
use Illuminate\Http\Request;

class RetrabalhosController
{
    public function __construct(
        public readonly RetrabalhoBusinessContract $retrabalhoBusiness
    )
    {
    }

    public function listarRetrabalhos(Request $request, int $idEquipe)
    {
        return $this->retrabalhoBusiness->buscarTodosPorEquipe($idEquipe);
    }

    public function inserirRetrabalho(Request $request)
    {
        if(!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 422);
        }
        $retrabalhoDTO = RetrabalhoCasoTesteDTO::from($request->all());
        return $this->retrabalhoBusiness->salvar($retrabalhoDTO, $request->get('idEquipe'));
    }
}
