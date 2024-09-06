<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories;

use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use Spatie\LaravelData\DataCollection;

interface CheckpointRepositoryContract
{
    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO;
    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO;
    public function delete(int $id): bool;
    public function list(int $idEquipe): DataCollection;
    public function getCheckpoint(int $id): CheckpointDTO;
    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO;
}
