<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Models\PlanoTesteExecucao;
use App\System\Impl\BaseRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoRepository extends BaseRepository  implements PlanoTesteExecucaoRepositoryContract
{

    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe):?PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('plano_teste_id', $idPlanoTeste)
            ->where('equipe_id',$idEquipe)
            ->orderBy('created_at', 'DESC')
            ->with(['plano_teste','user'])
            ->first();
        return $planoTesteExecucao ? PlanoTesteExecucaoDTO::from($planoTesteExecucao) : null;
    }

    public function criarExecucaoTeste(int $idPlanoTeste, int $idEquipe): PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = new PlanoTesteExecucao(
            [
                'user_id' => Auth::user()->id,
                'plano_teste_id' => $idPlanoTeste,
                'equipe_id' => $idEquipe
            ]
        );
        $planoTesteExecucao->save();
        return PlanoTesteExecucaoDTO::from($planoTesteExecucao);
    }

    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao, int $idEquipe): ?PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('plano_teste_execucoes.id',$idPlanoTesteExecucao)
                                ->where('equipe_id',$idEquipe)
                                ->with(['plano_teste','user'])
                                ->first();
        return $planoTesteExecucao ? PlanoTesteExecucaoDTO::from($planoTesteExecucao) : null;
    }

    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, string $resultado, int $idEquipe): bool
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('equipe_id',$idEquipe)
                                    ->where('id',$idPlanoTesteExecucao)
                                    ->first();
        $planoTesteExecucao->resultado = $resultado;
        $planoTesteExecucao->data_execucao = Carbon::now();

        return $planoTesteExecucao->save();
    }

    public function buscarTodosPlanoTesteExecucao(int $idEquipe): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
                    PlanoTesteExecucao::where('equipe_id',$idEquipe)
                        ->orderBy('created_at','DESC')
                        ->with(['plano_teste','user'])
                        ->get()
                );
    }

    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
                    PlanoTesteExecucao::where('plano_teste_id',$idPlanoTeste)
                        ->where('equipe_id',$idEquipe)
                        ->orderBy('created_at', 'DESC')
                        ->with(['plano_teste','user'])
                        ->get()
                );
    }
}
