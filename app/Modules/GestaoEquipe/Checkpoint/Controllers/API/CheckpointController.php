<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Controllers\API;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;


class CheckpointController extends Controller
{
    public function __construct(
        private readonly CheckpointBusinessContract $checkpointBusiness,

    )
    {
    }

    public function lista(Request $request)
    {
        if(!$idEquipe = $request->get('idEquipe')){
            return response()->json(['message' => 'O id da equipe é obrigatório'], 400);
        }
        return response()->json($this->checkpointBusiness->list($idEquipe), 200);
    }
    public function listaUsuarios(Request $request)
    {
        if(!$idEquipe = $request->get('idEquipe')){
            return response()->json(['message' => 'O id da equipe é obrigatório'], 400);
        }
        return response()->json($this->checkpointBusiness->getListUser($idEquipe, intval($request->get('page')), intval($request->get('limit'))), 200);

    }
    public function listaUltimoCheckpoint(Request $request, int $idUsuario)
    {
        if(!$idEquipe = $request->get('idEquipe')){
            return response()->json(['message' => 'O id da equipe é obrigatório'], 400);
        }
        return response()->json(
                $this->checkpointBusiness->getLastCheckpoint($request->get('idEquipe'), $idUsuario),
                200);
    }
    public function listaProjetos(Request $request)
    {
        if(!$idEquipe = $request->get('idEquipe')){
            return response()->json(['message' => 'O id da equipe é obrigatório'], 400);
        }
        return response()->json($this->checkpointBusiness->getProjetos($idEquipe), 200);

    }

    public function listaAlocacaoPorData(Request $request, int $idUsuario, string $data)
    {
        $data = Carbon::createFromFormat('Y-m-d', $data);
        if(!$idEquipe = $request->get('idEquipe')){
            return response()->json(['message' => 'O id da equipe é obrigatório'], 400);
        }
        try{
            return response()->json($this->checkpointBusiness->listarAlocacoesPorData($idEquipe, $idUsuario, $data), 200);
        }catch (NotFoundException | UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

}
