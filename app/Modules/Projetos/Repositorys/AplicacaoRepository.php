<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class AplicacaoRepository implements AplicacaoRepositoryContract
{

    public function buscarTodos(int $idEquipe): DataCollection
    {
        return AplicacaoDTO::collection(
            Aplicacao::join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
                ->where('aplicacoes_equipes.equipe_id',$idEquipe)
                ->get()
        );
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        DB::beginTransaction();
        try{
            $aplicacao = new Aplicacao($aplicacaoDTO->only('nome','descricao')->toArray());
            $aplicacao->save();
            $idsEquipe = [];
            $aplicacaoDTO->equipes->each(function ($item, $key) use ($aplicacao, &$idsEquipe){
                $idsEquipe[] = $item->id;
            });
            $aplicacao->equipes()->sync($idsEquipe);
            DB::commit();
            return AplicacaoDTO::from($aplicacao);
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function buscarPorId(int $id, int $idEquipe): ?AplicacaoDTO
    {
        $aplicacao = Aplicacao::join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->where('id',$id)
            ->first();
        return ($aplicacao != null ?  AplicacaoDTO::from($aplicacao) : null);
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        $aplicacao = Aplicacao::find($aplicacaoDTO->id);
        $aplicacao->fill($aplicacaoDTO->toArray());
        $aplicacao->update();
        return AplicacaoDTO::from($aplicacao);
    }

    public function excluir(int $id): bool
    {
        $aplicacao = Aplicacao::find($id);
        return $aplicacao->delete();
    }
}
