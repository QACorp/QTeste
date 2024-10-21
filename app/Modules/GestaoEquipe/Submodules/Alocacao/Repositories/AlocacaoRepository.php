<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Repositories;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\AlocacaoCancelamentoDTO;
use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\FiltroConsultaAlocacaoDTO;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\Alocacao;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\AlocacaoCancelamento;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\User;
use App\System\DTOs\UserDTO;
use App\System\Impl\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
            ->with(['projeto', 'user', 'user.empresa','equipe', 'projeto.aplicacao', 'tarefa'])
            ->first();
        if($alocacao) {
            return AlocacaoDTO::from($alocacao);
        }
        return null;
    }
    private function getQUeryBuilderSelectAlocacao(int $idEquipe): Builder
    {
        return Alocacao::select('alocacoes.*')
            ->where('equipe_id', $idEquipe)
            ->where('concluida', null)
            ->whereRaw('NOT EXISTS(SELECT 1 FROM gestao_equipes.alocacao_cancelamentos WHERE alocacao_id = alocacoes.id)')
            ->with(['projeto', 'user', 'user.empresa','equipe', 'projeto.aplicacao','tarefa', 'cancelamento'])
            ->orderBy('inicio', 'ASC');
    }

    public function listarAlocacoes(int $idEquipe, FiltroConsultaAlocacaoDTO $filtro = null): DataCollection
    {
        $alocacoes = $this->getQUeryBuilderSelectAlocacao($idEquipe)
            ->leftJoin('projetos.projetos as projetos', 'projetos.id', '=', 'alocacoes.projeto_id');

        if($filtro && $filtro->idUsuario){
            $alocacoes->where('user_id', $filtro->idUsuario);
        }
        if($filtro && $filtro->idProjeto){
            $alocacoes->where('projeto_id', $filtro->idProjeto);
        }
        if($filtro && $filtro->idAplicacao){
            $alocacoes->where('projetos.aplicacao_id', $filtro->idAplicacao);
        }
        if($filtro && $filtro->dataInicio){
            $alocacoes->where('alocacoes.inicio', '>=', $filtro->dataInicio);
        }
        if($filtro && $filtro->dataTermino){
            $alocacoes->where('alocacoes.termino', '<=',$filtro->dataTermino);
        }
        return AlocacaoDTO::collection($alocacoes->get());
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

    public function listarAlocacoesPorData(int $idEquipe, int $idUsuario, Carbon $data): DataCollection
    {
        $alocacoes = $this->getQUeryBuilderSelectAlocacao($idEquipe)
            ->where(function(Builder $query) use ($data){
                $query->whereRaw("? BETWEEN inicio AND termino");
                $query->setBindings([
                    $data->format('Y-m-d')
                ]);
            })
            ->where('user_id', $idUsuario)
            ->get();
        return AlocacaoDTO::collection($alocacoes);
    }

    public function cancelarAlocacao(AlocacaoCancelamentoDTO $alocacaoCancelamento): AlocacaoDTO
    {
        $alocacaoCancelamentoModel = new AlocacaoCancelamento($alocacaoCancelamento->toArray());
        $alocacaoCancelamentoModel->save();
        $alocacao = Alocacao::where('id', $alocacaoCancelamento->alocacao_id)->with('cancelamento')->first();
        return AlocacaoDTO::from($alocacao);

    }
}
