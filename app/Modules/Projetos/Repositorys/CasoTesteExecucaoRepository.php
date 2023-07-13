<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Models\CasoTesteExecucao;
use App\System\Impl\BaseRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoRepository extends BaseRepository  implements CasoTesteExecucaoRepositoryContract
{


    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status, int $idEquipe): bool
    {
        $casoTesteExecucao = new CasoTesteExecucao([
            'resultado' => $status,
            'caso_teste_id' => $idCasoTeste,
            'plano_teste_execucao_id' => $idPlanoTesteExecucao,
            'data_execucao' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'equipe_id' => $idEquipe
        ]);
        return $casoTesteExecucao->save();
    }

    public function buscarCasoTesteExecucao(int $idPlanoTesteExecucao, int $idCasoTeste, int $idEquipe): ?CasoTesteExecucaoDTO
    {
        $casoTesteExecucao = CasoTesteExecucao::where('plano_teste_execucao_id', $idPlanoTesteExecucao)
            ->where('caso_teste_id', $idCasoTeste)
            ->where('equipe_id', $idEquipe)
            ->with(['caso_teste', 'plano_teste_execucao'])
            ->first();
        return $casoTesteExecucao ? CasoTesteExecucaoDTO::from($casoTesteExecucao) : null;
    }

    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao, int $idEquipe): DataCollection
    {
        return PlanoTesteExecucaoDTO::collection(
            $casoTesteExecucao = CasoTesteExecucao::where('plano_teste_execucao_id', $idPlanoTesteExecucao)
                ->where('equipe_id', $idEquipe)
                ->with(['caso_teste', 'plano_teste_execucao'])
                ->get()
        );
    }
}
