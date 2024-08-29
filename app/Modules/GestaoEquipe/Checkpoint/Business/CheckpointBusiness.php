<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Business;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use Spatie\LaravelData\DataCollection;

class CheckpointBusiness implements CheckpointBusinessContract
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
