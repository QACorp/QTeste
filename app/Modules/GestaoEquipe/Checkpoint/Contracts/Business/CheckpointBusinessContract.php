<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Contracts\Business;

use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

interface CheckpointBusinessContract
{
    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO;
    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO;
    public function delete(int $id): bool;
    public function list(int $idEquipe): DataCollection;
    public function getCheckpoint(int $id): CheckpointDTO;
    public function getListUser(int $idEquipe, int $page = null, int $limit = null):DataCollection|PaginatedDataCollection;
}
