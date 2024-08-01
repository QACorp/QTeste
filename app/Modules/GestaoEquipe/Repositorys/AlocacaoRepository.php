<?php

namespace App\Modules\GestaoEquipe\Repositorys;

use App\Modules\GestaoEquipe\Contracts\Repositorys\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Models\Alocacao;
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

    public function listarAlocacoes(int $idEquipe): DataCollection
    {
        $alocacoes = Alocacao::where('equipe_id', $idEquipe)
            ->where('concluida', null)
            ->with(['projeto', 'user', 'user.empresa','equipe', 'projeto.aplicacao'])
            ->orderBy('inicio', 'desc')
            ->get();
        return AlocacaoDTO::collection($alocacoes);
    }

    public function listarAlocacoesPorUsuario(int $idUsuario, int $idEmpresa): DataCollection
    {
        // TODO: Implement listarAlocacoesPorUsuario() method.
    }
}
