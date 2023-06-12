<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\CasosTesteMaisFalhasRepositoryContract;
use App\Modules\Projetos\DTOs\TestesMaisFalhasDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use App\Modules\Projetos\Models\CasoTeste;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class CasosTesteMaisFalhasRepository implements CasosTesteMaisFalhasRepositoryContract
{

    public function buscarTotaisTestes($limit): DataCollection
    {
        return TestesMaisFalhasDTO::collection(
            CasoTeste::select(DB::raw("*,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE cte2.caso_teste_id = casos_teste.id AND resultado = 'Falhou') as total_execucoes"))
                ->join('projetos.caso_teste_execucoes', function (JoinClause $join){
                    $join->on("casos_teste.id", "=", "caso_teste_execucoes.caso_teste_id")
                        ->on("resultado", "=", DB::raw("'Falhou'"));
                })
                ->orderBy('total_execucoes','DESC')
                ->limit($limit)
                ->get()
        );
    }
}
