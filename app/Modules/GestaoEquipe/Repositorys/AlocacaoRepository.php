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
        $alocacaoModel = Alocacao::find($id);
        $alocacaoModel->fill($dados->except('empresa_id', 'equipe_id')->toArray());
        $alocacaoModel->save();
        return AlocacaoDTO::from($alocacaoModel);
    }

    public function excluirAlocacao(int $id): bool
    {
        // TODO: Implement excluirAlocacao() method.
    }

    public function consultarAlocacao(int $id, int $idEquipe): ?AlocacaoDTO
    {
        $alocacao = Alocacao::where('equipe_id', $idEquipe)
            ->where('id', $id)
            ->with(['projeto', 'user', 'user.empresa','equipe', 'projeto.aplicacao'])
            ->first();
        if($alocacao)
            return AlocacaoDTO::from($alocacao);
        return null;
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

    public function hasAlocacaoInDate(int $userId, int $equipeId, string $inicio, string $termino): bool
    {
        return Alocacao::where('user_id', $userId)
            ->where('equipe_id', $equipeId)
            ->whereBetween('inicio', [$inicio, $termino])
            ->whereBetween('termino', [$inicio, $termino])
            ->count() > 0;
    }
}
