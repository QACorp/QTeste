<?php

namespace App\Modules\GestaoEquipe\Business;

use App\Modules\GestaoEquipe\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class AlocacaoBusiness extends BusinessAbstract implements AlocacaoBusinessContract
{

    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO
    {
        // TODO: Implement criarAlocacao() method.
    }

    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO
    {
        // TODO: Implement alterarAlocacao() method.
    }

    public function excluirAlocacao(int $id): bool
    {
        // TODO: Implement excluirAlocacao() method.
    }

    public function consultarAlocacao(int $id): DataCollection
    {
        // TODO: Implement consultarAlocacao() method.
    }

    public function listarAlocacoes(): DataCollection
    {
        // TODO: Implement listarAlocacoes() method.
    }
}
