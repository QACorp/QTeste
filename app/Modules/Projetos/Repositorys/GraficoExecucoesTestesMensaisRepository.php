<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\GraficoExecucoesTestesMensaisRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\ExecucoesTestesMensaisDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class GraficoExecucoesTestesMensaisRepository implements GraficoExecucoesTestesMensaisRepositoryContract
{

    public function buscarTotaisExecucoes(): DataCollection
    {
        return ExecucoesTestesMensaisDTO::collection(
            DB::select("SELECT
                                data,
                                count(data) as quantidade
                            FROM (SELECT
                                      extract(year from data_execucao) || '/' || extract(month from data_execucao) as data
                                  FROM projetos.plano_teste_execucoes
                                  WHERE data_execucao IS NOT NULL
                                  GROUP BY data_execucao) as execucoes
                            GROUP BY data")
        );
    }
}
