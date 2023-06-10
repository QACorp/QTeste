<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\TestesMaisExecutadosRepositoryContract;
use App\Modules\Projetos\DTOs\TestesMaisExecutadosDTO;
use App\Modules\Projetos\Models\CasoTeste;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class TestesMaisExecutadosRepository implements TestesMaisExecutadosRepositoryContract
{

    public function buscarTestesPorOrdemMaisExecutado(int $limit): DataCollection
    {
        return TestesMaisExecutadosDTO::collection(
            CasoTeste::select(DB::raw('*,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE cte2.caso_teste_id = casos_teste.id) as total_execucoes'))
            ->orderBy('total_execucoes','DESC')
            ->limit($limit)
            ->get()
        );
    }
}
