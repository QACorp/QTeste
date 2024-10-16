<?php

namespace App\Modules\GestaoEquipe\Submodules\Observacao\Contracts\Respositories;

use App\Modules\GestaoEquipe\Submodules\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Submodules\Observacao\DTOs\ObservacaoDTO;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

interface ObservacaoRepositoryContract
{
    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO;
    public function atualizar(int $id, ObservacaoDTO $observacaoDTO, int $idEquipe): ?ObservacaoDTO;
    public function deletar(int $id, int $idEquipe): bool;
    public function buscarPorId(int $idObservacao, int $idEquipe): ?ObservacaoDTO;
    public function listaPorIdEData(int $idUsuario, int $idEquipe, int $idUsuarioCriador, ?Carbon $inicio = null, ?Carbon $termino = null): DataCollection;
    public function buscarObservacaoComCheckpoint(int $idUsuario, int $idEquipe, ?Carbon $inicio = null, ?Carbon $termino = null): DataCollection;
}
