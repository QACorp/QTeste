<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Models\PlanoTesteExecucao;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoRepository implements PlanoTesteExecucaoRepositoryContract
{

    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste):?PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('plano_teste_id', $idPlanoTeste)
            ->orderBy('created_at', 'DESC')
            ->with(['plano_teste','user'])
            ->first();
        return $planoTesteExecucao ? PlanoTesteExecucaoDTO::from($planoTesteExecucao) : null;
    }

    public function criarExecucaoTeste(int $idPlanoTeste): PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = new PlanoTesteExecucao(
            [
                'user_id' => Auth::user()->id,
                'plano_teste_id' => $idPlanoTeste
            ]
        );
        $planoTesteExecucao->save();
        return PlanoTesteExecucaoDTO::from($planoTesteExecucao);
    }

    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao): ?PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('id',$idPlanoTesteExecucao)
                                ->with(['plano_teste','user'])
                                ->first();
        return $planoTesteExecucao ? PlanoTesteExecucaoDTO::from($planoTesteExecucao) : null;
    }

    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, string $resultado): bool
    {
        $planoTesteExecucao = PlanoTesteExecucao::find($idPlanoTesteExecucao);
        $planoTesteExecucao->resultado = $resultado;
        $planoTesteExecucao->data_execucao = Carbon::now();

        return $planoTesteExecucao->save();
    }

    public function buscarTodosPlanoTesteExecucao(): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
                    PlanoTesteExecucao::orderBy('created_at','DESC')
                        ->with(['plano_teste','user'])
                        ->get()
                );
    }

    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
                    PlanoTesteExecucao::where('plano_teste_id',$idPlanoTeste)
                        ->orderBy('created_at', 'DESC')
                        ->with(['plano_teste','user'])
                        ->get()
                );
    }
}
