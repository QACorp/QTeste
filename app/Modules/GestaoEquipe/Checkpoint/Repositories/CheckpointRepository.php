<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Repositories;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Checkpoint\Models\Checkpoint;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class CheckpointRepository implements CheckpointRepositoryContract
{

    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO
    {
        // TODO: Implement create() method.
    }

    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    public function list(int $idEquipe): DataCollection
    {
        return new DataCollection(CheckpointDTO::class, []);
    }

    public function getCheckpoint(int $id): CheckpointDTO
    {
        // TODO: Implement getCheckpoint() method.
    }

    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO
    {
        $checkpoint = Checkpoint::select('checkpoints.*')
                                ->where('equipe_id', $idEquipe)
                                ->where('user_id', $idUsuario)
                                ->orderBy('data', 'desc')
                                ->with('projeto','user', 'criador', 'projeto.aplicacao', 'alocacao')
                                ->first();
        return $checkpoint ? CheckpointDTO::from($checkpoint) : null;
    }

}
