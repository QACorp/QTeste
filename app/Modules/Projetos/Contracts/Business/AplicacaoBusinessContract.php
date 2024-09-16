<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\AplicacoesPutRequest;
use Spatie\LaravelData\DataCollection;

interface AplicacaoBusinessContract
{
    public function buscarTodos(int $idEquipe, string $guard = 'web'):DataCollection;
    public function buscarPorId(int $id, int $idEquipe, string $guard = 'web'):AplicacaoDTO;
    public function salvar(AplicacaoDTO $aplicacaoDTO, AplicacoesPostRequest $aplicacoesPostRequest = new AplicacoesPostRequest()):AplicacaoDTO;

    public function alterar(AplicacaoDTO $aplicacaoDTO, int $equipeId, AplicacoesPutRequest $aplicacoesPutRequest = new AplicacoesPutRequest()): AplicacaoDTO;

    public function excluir(int $id, int $equipeId): bool;
}
