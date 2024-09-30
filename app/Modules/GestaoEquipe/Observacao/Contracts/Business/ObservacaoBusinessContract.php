<?php

namespace App\Modules\GestaoEquipe\Observacao\Contracts\Business;

use App\Modules\GestaoEquipe\Observacao\DTOs\ObservacaoDTO;
use Spatie\LaravelData\DataCollection;
interface ObservacaoBusinessContract
{
    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO;
    public function atualizar(int $id, ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO;
    public function deletar(int $id, int $idEquipe): bool;
    public function buscarObservacaoComCheckpoint(int $idUsuario, int $idEquipe): DataCollection;
}
