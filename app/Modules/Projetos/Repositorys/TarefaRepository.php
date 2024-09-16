<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\TarefaRepositoryContract;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\Modules\Projetos\Models\Tarefa;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Spatie\LaravelData\DataCollection;

class TarefaRepository implements TarefaRepositoryContract
{

    public function createTarefa(TarefaDTO $data): TarefaDTO
    {
        try{
            $tarefa = new Tarefa($data->toArray());
            $tarefa->save();
            return TarefaDTO::from($tarefa);
        }catch (UniqueConstraintViolationException $e){
            throw new ConflictException('Tarefa já cadastrada');
        }

    }

    public function getTarefaById(string $tarefa): ?TarefaDTO
    {
        try {
            return TarefaDTO::from(Tarefa::where('tarefa',$tarefa)->firstOrFail());
        }catch (ModelNotFoundException $e){
            throw new NotFoundException('Tarefa não encontrada');
        }
    }

    public function updateTarefa(string $tarefa, TarefaDTO $data): TarefaDTO
    {
        try{
            $tarefa = Tarefa::where('tarefa',$tarefa)->firstOrFail();
            $tarefa->fill($data->only('titulo','tarefa')->toArray());
            $tarefa->save();
            return TarefaDTO::from($tarefa);
        }catch (UniqueConstraintViolationException $e){
            throw new ConflictException('Tarefa já cadastrada');
        }catch (ModelNotFoundException $e){
            throw new NotFoundException('Tarefa não encontrada');
        }

    }

    public function deleteTarefa(string $tarefa): bool
    {
        // TODO: Implement deleteTarefa() method.
    }

    public function listTarefas(): DataCollection
    {
        return TarefaDTO::collection(Tarefa::all());
    }
}
