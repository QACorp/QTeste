<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\AplicacoesPutRequest;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

interface AplicacaoBusinessContract
{
    public function buscarTodos():DataCollection;
    public function buscarPorId(int $id):AplicacaoDTO;
    public function salvar(AplicacaoDTO $aplicacaoDTO, AplicacoesPostRequest $aplicacoesPostRequest = new AplicacoesPostRequest()):AplicacaoDTO;

    public function alterar(AplicacaoDTO $aplicacaoDTO, AplicacoesPutRequest $aplicacoesPutRequest = new AplicacoesPutRequest()): AplicacaoDTO;

    public function excluir(int $id): bool;
}
