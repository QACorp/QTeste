<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories;

use App\Modules\GestaoEquipe\Submodules\Checkpoint\DTOs\CheckpointDTO;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

interface CheckpointRepositoryContract
{
    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO;
    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO;
    public function delete(int $id): bool;
    public function list(int $idEquipe): DataCollection;
    public function getCheckpoint(int $id): CheckpointDTO;
    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO;
    public function listarCheckpointPorAlocacao(int $idEquipe, int $idAlocacao): DataCollection;
    public function listarCheckpointPorUsuario(int $idEquipe, int $idUsuario): DataCollection;
    public function listarCheckpointPorUsuarioEData(int $idEquipe, int $idUsuario, ?Carbon $inicio, ?Carbon $termino): DataCollection;
}
