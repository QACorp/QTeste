<?php

namespace App\Modules\GestaoEquipe\Repositorys;

use App\Modules\GestaoEquipe\Contracts\Repositorys\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Models\Alocacao;
use App\Modules\GestaoEquipe\Models\User;
use App\System\DTOs\UserDTO;
use App\System\Impl\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;

class AlocacaoRepository extends BaseRepository implements AlocacaoRepositoryContract
{

    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO
    {
        $alocacaoModel = new Alocacao();
        $alocacaoModel->fill($dados->toArray());
        $alocacaoModel->save();
        return AlocacaoDTO::from($alocacaoModel);
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
        if($alocacao) {
            return AlocacaoDTO::from($alocacao);
        }
        return null;
    }
    private function getQUeryBuilderSelectAlocacao(int $idEquipe): Builder
    {
        return Alocacao::where('equipe_id', $idEquipe)
            ->where('concluida', null)
            ->with(['projeto', 'user', 'user.empresa','equipe', 'projeto.aplicacao'])
            ->orderBy('inicio', 'desc');
    }

    public function listarAlocacoes(int $idEquipe): DataCollection
    {
        $alocacoes = $this->getQUeryBuilderSelectAlocacao($idEquipe)
            ->get();
        return AlocacaoDTO::collection($alocacoes);
    }

    public function listarAlocacoesPorUsuario(int $idEquipe, int $idUsuario): DataCollection
    {
        $alocacoes = $this->getQUeryBuilderSelectAlocacao($idEquipe)
                        ->where('user_id', $idUsuario)
                        ->get();
        return AlocacaoDTO::collection($alocacoes);
    }

    public function hasAlocacaoInDate(int $userId, int $equipeId, string $inicio, string $termino, int $alocacaoId = null): bool
    {
        $alocacaoBuilder =  Alocacao::where('user_id', $userId)
            ->where('equipe_id', $equipeId)
            ->where(function(Builder $query) use ($inicio, $termino){
                $query->whereBetween('inicio', [$inicio, $termino])
                    ->orWhereBetween('termino', [$inicio, $termino]);
            })
            ->whereNull('concluida');
        if($alocacaoId != null){
            $alocacaoBuilder->where('id', '<>', $alocacaoId);
        }
        return $alocacaoBuilder->count() > 0;
    }

    public function usuariosDisponiveis(int $idEquipe, Carbon $inicio, Carbon $termino): DataCollection
    {
        $usuarios = User::whereDoesntHave('alocacoes', function ($query) use ($inicio, $termino, $idEquipe) {
                $query->where(function(Builder $query) use ($inicio, $termino){
                    $query->whereRaw("? BETWEEN inicio AND termino")
                        ->orWhereRaw("? BETWEEN inicio AND termino");
                    $query->setBindings([
                        $inicio->format('Y-m-d'),
                        $termino->format('Y-m-d')
                    ]);
                })
                ->whereNull('concluida')
                ->where('equipe_id', $idEquipe);
            })
            ->whereHas('equipes', function ($query) use ($idEquipe) {
                $query->where('equipe_id', $idEquipe);
            })
            ->where('active', true)
            ->get();
        return UserDTO::collection($usuarios);
    }

}
