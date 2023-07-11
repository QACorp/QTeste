<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\TestesMaisExecutadosRepositoryContract;
use App\Modules\Projetos\DTOs\TestesMaisExecutadosDTO;
use App\Modules\Projetos\Models\CasoTeste;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class TestesMaisExecutadosRepository implements TestesMaisExecutadosRepositoryContract
{

    public function buscarTestesPorOrdemMaisExecutado(int $limit, int $idEquipe): DataCollection
    {
        return TestesMaisExecutadosDTO::collection(
            CasoTeste::select(DB::raw('DISTINCT casos_teste.id, casos_teste.*,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE cte2.caso_teste_id = casos_teste.id AND cte2.equipe_id = casos_teste_equipes.equipe_id) as total_execucoes'))
            ->join('projetos.casos_teste_equipes','casos_teste_equipes.caso_teste_id','=','casos_teste.id')
            ->join('projetos.caso_teste_execucoes','caso_teste_execucoes.caso_teste_id', '=','casos_teste.id' )
            ->where('casos_teste_equipes.equipe_id',$idEquipe)
            ->limit($limit)
            ->orderBy('total_execucoes','DESC')
            ->get()
        );
    }
}
