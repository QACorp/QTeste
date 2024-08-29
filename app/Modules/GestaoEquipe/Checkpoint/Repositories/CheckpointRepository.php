<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Repositories;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
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
        // TODO: Implement list() method.
    }

    public function getCheckpoint(int $id): CheckpointDTO
    {
        // TODO: Implement getCheckpoint() method.
    }
}
