<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Controllers\API;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CheckpointController extends Controller
{
    public function __construct(
        private readonly CheckpointBusinessContract $checkpointBusiness
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

}
