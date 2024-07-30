<?php

namespace App\Modules\GestaoEquipe\Repositorys;

use App\Modules\GestaoEquipe\Contracts\Repositorys\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\System\Impl\BaseRepository;
use Spatie\LaravelData\DataCollection;

class AlocacaoRepository extends BaseRepository implements AlocacaoRepositoryContract
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
