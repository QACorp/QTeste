<?php

namespace App\Modules\GestaoEquipe\Submodules\Observacao\Repositories;

use App\Modules\GestaoEquipe\DTOs\CheckpointObservacaoDTO;
use App\Modules\GestaoEquipe\Helpers\QueryDataHelper;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\Models\Checkpoint;
use App\Modules\GestaoEquipe\Submodules\Observacao\Contracts\Respositories\ObservacaoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Observacao\DTOs\ObservacaoDTO;
use App\Modules\GestaoEquipe\Submodules\Observacao\Models\Observacao;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Spatie\LaravelData\DataCollection;

class ObservacaoRepository implements ObservacaoRepositoryContract
{

    private function getQueryObservacoes(int $idUsuario, int $idEquipe, int $idUsuarioCriador): Builder
    {
        return Observacao::select('observacoes.*')
            ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
            ->where('observacoes.user_id', $idUsuario)
            ->where('criador_user_id', $idUsuarioCriador)
            ->where('equipe_id', $idEquipe)
            ->orderBy('observacoes.data', 'desc')
            ->orderBy('observacoes.id', 'desc')
            ->with(['user', 'criador']);
    }
    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection
    {
        $observacoes = $this->getQueryObservacoes(...func_get_args())->get();
        return ObservacaoDTO::collection($observacoes);
    }

    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO
    {
        $observacaoModel = new Observacao($observacaoDTO->except('user', 'criador')->toArray());
        $observacaoModel->save();
        return ObservacaoDTO::from($observacaoModel);
    }

    public function atualizar(int $id, ObservacaoDTO $observacaoDTO, int $idEquipe): ?ObservacaoDTO
    {
        $observacao = Observacao::select('observacoes.*')
                        ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
                        ->where('equipe_id', $idEquipe)
                        ->where('observacoes.id', $id)
                        ->first();
        if(!$observacao){
            return null;
        }
        $observacao->update($observacaoDTO->only('observacao')->toArray());
        return ObservacaoDTO::from($observacao);
    }

    public function deletar(int $id, int $idEquipe): bool
    {
        $observacao = Observacao::select('observacoes.*')
                        ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
                        ->where('equipe_id', $idEquipe)
                        ->where('observacoes.id', $id)
                        ->first();
        if(!$observacao){
            return false;
        }
        return $observacao->delete();
    }

    public function buscarPorId(int $idObservacao, int $idEquipe): ?ObservacaoDTO
    {
        $observacao = Observacao::select('observacoes.*')
                        ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
                        ->where('observacoes.id', $idObservacao)
                        ->where('equipe_id', $idEquipe)
                        ->first();
        return $observacao ? ObservacaoDTO::from($observacao) : null;
    }


    public function buscarObservacaoComCheckpoint(int $idUsuario, int $idEquipe, ?Carbon $inicio = null, ?Carbon $termino = null): DataCollection
    {
        $listaCheckpoints = Checkpoint::selectRaw('checkpoints.id, checkpoints.user_id, checkpoints.criador_user_id, descricao, data, \'Checkpoint\' as tipo, tarefa_id, projeto_id')
            ->where('checkpoints.user_id', $idUsuario)
            ->where('equipe_id', $idEquipe);
        QueryDataHelper::addFilterInicioTermino($listaCheckpoints, $inicio, $termino);

        $listaObservacao = Observacao::selectRaw('observacoes.id, observacoes.user_id, observacoes.criador_user_id, observacao as descricao, data,\'Observacao\' as tipo, null as tarefa_id, null as projeto_id')
            ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
            ->where('observacoes.user_id', $idUsuario)
            ->where('equipe_id', $idEquipe);

        QueryDataHelper::addFilterInicioTermino($listaObservacao, $inicio, $termino);

        $listaCheckpoints->union($listaObservacao)
            ->with(['user', 'criador', 'projeto', 'tarefa'])
            ->orderBy('data', 'desc')
            ->orderBy('id', 'desc');
        return CheckpointObservacaoDTO::collection($listaCheckpoints->get());
    }

    public function listaPorIdEData(int $idUsuario, int $idEquipe, int $idUsuarioCriador, ?Carbon $inicio = null, ?Carbon $termino = null): DataCollection
    {
        $observacoes = $this->getQueryObservacoes($idUsuario, $idEquipe, $idUsuarioCriador);
        QueryDataHelper::addFilterInicioTermino($observacoes, $inicio, $termino);

        return ObservacaoDTO::collection($observacoes->get());
    }
}
