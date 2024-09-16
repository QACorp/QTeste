<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\TarefaDTO;
use Spatie\LaravelData\DataCollection;

interface TarefaBusinessContract
{
    public function createTarefa(TarefaDTO $data): TarefaDTO;
    public function getTarefaById(string $tarefa): ?TarefaDTO;
    public function updateTarefa(string $tarefa, TarefaDTO $data): TarefaDTO;
    public function deleteTarefa(string $tarefa): bool;
    public function listTarefas(): DataCollection;
}
