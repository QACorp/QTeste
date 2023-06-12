<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use Illuminate\Support\Facades\DB;

class TotaisTestesRepository implements TotaisTestesRepositoryContract
{

    public function buscarTotaisTestes(): TotaisTestesDTO
    {

       return TotaisTestesDTO::from(
            DB::select('SELECT
                (SELECT
                     COUNT(id)
                 FROM projetos.aplicacoes
                 WHERE
                     deleted_at is null
                 ) as total_aplicacoes,
                (SELECT
                     COUNT(id)
                 FROM projetos.planos_teste
                 WHERE
                     deleted_at is null
                ) as total_planos_teste,
                (SELECT
                     COUNT(id)
                 FROM projetos.casos_teste
                 WHERE
                     deleted_at is null
                ) as total_casos_teste,
                (SELECT
                     COUNT(id)
                 FROM projetos.projetos
                 WHERE
                     deleted_at is null
                ) as total_projetos
            ')[0]
        );
    }
}
