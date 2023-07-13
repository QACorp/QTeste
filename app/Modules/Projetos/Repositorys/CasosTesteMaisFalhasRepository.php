<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\CasosTesteMaisFalhasRepositoryContract;
use App\Modules\Projetos\DTOs\TestesMaisFalhasDTO;
use App\Modules\Projetos\Models\CasoTeste;
use App\System\Impl\BaseRepository;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class CasosTesteMaisFalhasRepository extends BaseRepository  implements CasosTesteMaisFalhasRepositoryContract
{

    public function buscarTotaisTestes(int $limit, int $idEquipe): DataCollection
    {
        return TestesMaisFalhasDTO::collection(
            CasoTeste::select(DB::raw("DISTINCT casos_teste.id, casos_teste.*,
                (SELECT
                     COUNT(cte2.id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE cte2.caso_teste_id = casos_teste.id AND
                 resultado = 'Falhou' AND
                 cte2.equipe_id = casos_teste_equipes.equipe_id) as total_execucoes"))
                ->join('projetos.casos_teste_equipes','casos_teste_equipes.caso_teste_id','=','casos_teste.id')
                ->join('projetos.caso_teste_execucoes', function (JoinClause $join){
                    $join->on("casos_teste.id", "=", "caso_teste_execucoes.caso_teste_id")
                        ->on("resultado", "=", DB::raw("'Falhou'"));
                })
                ->where('casos_teste_equipes.equipe_id',$idEquipe)
                ->orderBy('total_execucoes','DESC')
                ->limit($limit)
                ->get()
        );
    }
}
