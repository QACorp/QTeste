<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Business;

use App\Modules\GestaoEquipe\Submodules\Checkpoint\DTOs\CheckpointDTO;
use Carbon\Carbon;
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
    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO;
    public function getProjetos(int $idEquipe): DataCollection;
    public function listarAlocacoesPorData(int $idEquipe, int $idUsuario, Carbon $data): DataCollection;
    public function listarCheckpointPorAlocacao(int $idEquipe, $idAlocacao): DataCollection;
    public function listarCheckpointsPorUsuario(int $idEquipe, int $idUsuario): DataCollection;
    public function listarCheckpointPorUsuarioEData(int $idEquipe, int $idUsuario, ?Carbon $inicio, ?Carbon $termino): DataCollection;

}
