<?php

namespace App\Modules\Projetos\Controllers\API;

use App\Modules\Projetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{
    public function __construct(
        private readonly TarefaBusinessContract $tarefaBusiness
    )
    {
    }

    public function listaTarefas()
    {
        return response()->json($this->tarefaBusiness->listTarefas());
    }

    public function criarTarefa(Request $request)
    {
        $tarefaDTO = TarefaDTO::from($request->all());
        $tarefaDTO->empresa_id = Auth::user()->empresa_id;
        try {
            return response()->json($this->tarefaBusiness->createTarefa($tarefaDTO), 201);
        }catch (ConflictException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
    public function alterarTarefa(Request $request, $tarefa)
    {
        try{
            $tarefaDTO = TarefaDTO::from($request->all());
            return response()->json($this->tarefaBusiness->updateTarefa($tarefa, TarefaDTO::from($request->all())), 200);

        }catch (ConflictException | NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
    public function buscarTarefa(string $tarefa)
    {
        try{
            return response()->json($this->tarefaBusiness->getTarefaById($tarefa), 200);
        }catch (NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
