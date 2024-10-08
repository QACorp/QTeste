<?php

namespace App\Modules\GestaoEquipe\Controllers\API;

use App\Modules\GestaoEquipe\Alocacao\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use Carbon\Carbon;
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
        $inicio = null;
        $termino = null;
        if (!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        if($request->get('inicio')){
            $inicio = Carbon::createFromFormat('Y-m-d', $request->get('inicio'));
        }
        if($request->get('termino')){
            $termino = Carbon::createFromFormat('Y-m-d', $request->get('termino'));
        }
        try{
            return $this->observacaoBusiness->buscarObservacaoComCheckpoint($idUsuario, $request->get('idEquipe'), $inicio, $termino);
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
