<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Models\CasoTesteExecucao;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoRepository implements CasoTesteExecucaoRepositoryContract
{


    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status): bool
    {
        $casoTesteExecucao = new CasoTesteExecucao([
            'resultado' => $status,
            'caso_teste_id' => $idCasoTeste,
            'plano_teste_execucao_id' => $idPlanoTesteExecucao,
            'data_execucao' => Carbon::now(),
            'user_id' => Auth::user()->id
        ]);
        return $casoTesteExecucao->save();
    }

    public function buscarCasoTesteExecucao(int $idPlanoTesteExecucao, int $idCasoTeste): ?CasoTesteExecucaoDTO
    {
        $casoTesteExecucao = CasoTesteExecucao::where('plano_teste_execucao_id', $idPlanoTesteExecucao)
            ->where('caso_teste_id', $idCasoTeste)
            ->with(['caso_teste', 'plano_teste_execucao'])
            ->first();
        return $casoTesteExecucao ? CasoTesteExecucaoDTO::from($casoTesteExecucao) : null;
    }

    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
            $casoTesteExecucao = CasoTesteExecucao::where('plano_teste_execucao_id', $idPlanoTesteExecucao)
                ->with(['caso_teste', 'plano_teste_execucao'])
                ->get()
        );
    }
}
