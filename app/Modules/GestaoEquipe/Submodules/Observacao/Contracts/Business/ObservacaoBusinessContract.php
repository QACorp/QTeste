<?php

namespace App\Modules\GestaoEquipe\Submodules\Observacao\Contracts\Business;

use App\Modules\GestaoEquipe\Submodules\Observacao\DTOs\ObservacaoDTO;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

interface ObservacaoBusinessContract
{
    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO;
    public function atualizar(int $id, ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO;
    public function deletar(int $id, int $idEquipe): bool;
    public function buscarObservacaoComCheckpoint(int $idUsuario, int $idEquipe, ?Carbon $inicio = null, ?Carbon $termino = null): DataCollection;
}
