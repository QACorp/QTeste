<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\TarefaBusinessContract;
use App\Modules\Projetos\Contracts\Repository\TarefaRepositoryContract;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class TarefaBusiness extends BusinessAbstract implements TarefaBusinessContract
{
    public function __construct(
        private readonly TarefaRepositoryContract $tarefaRepository
    )
    {
    }

    public function createTarefa(TarefaDTO $data): TarefaDTO
    {
        try{
            return $this->tarefaRepository->createTarefa($data);
        }catch (ConflictException $e){
            throw $e;
        }

    }

    public function getTarefaById(string $tarefa): ?TarefaDTO
    {
        try {
            return $this->tarefaRepository->getTarefaById($tarefa);
        }catch (NotFoundException $e){
            throw $e;
        }
    }

    public function updateTarefa(string $tarefa, TarefaDTO $data): TarefaDTO
    {
        try {
            return $this->tarefaRepository->updateTarefa($tarefa, $data);
        }catch (ConflictException|NotFoundException $e){
            throw $e;
        }

    }

    public function deleteTarefa(string $tarefa): bool
    {
        // TODO: Implement deleteTarefa() method.
    }

    public function listTarefas(): DataCollection
    {
        return $this->tarefaRepository->listTarefas();
    }
}
