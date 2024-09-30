<?php

namespace App\Modules\GestaoEquipe\Controllers\API;

use App\Modules\GestaoEquipe\Alocacao\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GestaoEquipeController extends Controller
{
    public function __construct(
        private readonly AlocacaoBusinessContract $alocacaoBusiness,
        private readonly ObservacaoBusinessContract $observacaoBusiness,
        private readonly CheckpointBusinessContract $checkpointBusiness
    )
    {
    }

    public function buscarRegistros(Request $request, int $idUsuario)
    {
        if (!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        return $this->observacaoBusiness->buscarObservacaoComCheckpoint($idUsuario, $request->get('idEquipe'));
    }
}
