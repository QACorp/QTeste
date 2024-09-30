<?php

namespace App\Modules\GestaoEquipe\Observacao\Repositories;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Checkpoint\Models\Checkpoint;
use App\Modules\GestaoEquipe\Observacao\Contracts\Respositories\ObservacaoRepositoryContract;
use App\Modules\GestaoEquipe\Observacao\DTOs\ObservacaoDTO;
use App\Modules\GestaoEquipe\Observacao\Models\Observacao;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class ObservacaoRepository implements ObservacaoRepositoryContract
{


    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection
    {
        $observacoes = Observacao::select('observacoes.*')
                        ->join('users_equipes', 'users_equipes.user_id', '=', 'observacoes.user_id')
                        ->where('observacoes.user_id', $idUsuario)
                        ->where('criador_user_id', $idUsuarioCriador)
                        ->where('equipe_id', $idEquipe)
                        ->orderBy('observacoes.data', 'desc')
                        ->orderBy('observacoes.id', 'desc')
                        ->with(['user', 'criador'])->get();
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
}
