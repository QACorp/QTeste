<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Business\PlanoTesteExecucaoBusiness;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum;
use App\Modules\Projetos\Models\PlanoTeste;
use App\Modules\Projetos\Models\PlanoTesteExecucao;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoRepository implements PlanoTesteExecucaoRepositoryContract
{

    public function buscarPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste):?PlanoTesteExecucaoDTO
    {
        $planoTesteExecucao = PlanoTesteExecucao::where('plano_teste_id', $idPlanoTeste)
            ->whereNull('resultado')
            ->whereNull('data_execucao')
            ->with(['plano_teste'])
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
}
