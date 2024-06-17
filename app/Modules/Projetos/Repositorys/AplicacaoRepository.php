<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use App\System\DTOs\EquipeDTO;
use App\System\Impl\BaseRepository;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class AplicacaoRepository extends BaseRepository  implements AplicacaoRepositoryContract
{

    public function buscarTodos(int $idEquipe): DataCollection
    {
        return AplicacaoDTO::collection(
            Aplicacao::where('aplicacoes_equipes.equipe_id',$idEquipe)
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
            $aplicacao = $this->atualizarEquipe($aplicacaoDTO, $aplicacao);
            DB::commit();
            return AplicacaoDTO::from($aplicacao);
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

    }

    public function buscarPorId(int $id, int $idEquipe): ?AplicacaoDTO
    {
        $aplicacao = Aplicacao::where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->where('aplicacoes.id',$id)
            ->first();
        if($aplicacao != null){
            $aplicacaoDTO = AplicacaoDTO::from($aplicacao);
            $aplicacaoDTO->equipes = EquipeDTO::collection($aplicacao->equipes);
            return $aplicacaoDTO;
        }
        return null;
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        DB::beginTransaction();
        try {
            $aplicacao = Aplicacao::find($aplicacaoDTO->id);
            $aplicacao->fill($aplicacaoDTO->toArray());
            $aplicacao->update();
            $aplicacao = $this->atualizarEquipe($aplicacaoDTO, $aplicacao);
            DB::commit();
            return AplicacaoDTO::from($aplicacao);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
    private function atualizarEquipe(AplicacaoDTO $aplicacaoDTO, Aplicacao $aplicacao):Aplicacao
    {
        $idsEquipe = [];
        $aplicacaoDTO->equipes->each(function ($item, $key) use ($aplicacao, &$idsEquipe) {
            $idsEquipe[] = $item->id;
        });
        $aplicacao->equipes()->sync($idsEquipe);
        return $aplicacao;
    }
    public function excluir(int $id): bool
    {
        $aplicacao = Aplicacao::find($id);
        return $aplicacao->delete();
    }
}
