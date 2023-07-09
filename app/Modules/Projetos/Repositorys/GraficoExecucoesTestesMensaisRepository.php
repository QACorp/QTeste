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

    public function buscarTotaisExecucoes(int $idEquipe): DataCollection
    {
        return ExecucoesTestesMensaisDTO::collection(
            DB::select("SELECT
                                data,
                                count(data) as quantidade
                            FROM (SELECT
                                      extract(year from data_execucao) || '/' || extract(month from data_execucao) as data
                                  FROM projetos.plano_teste_execucoes
                                    JOIN projetos.planos_teste ON planos_teste.id = plano_teste_execucoes.plano_teste_id
                                    JOIN projetos.projetos ON projetos.id = planos_teste.projeto_id
                                    JOIN projetos.aplicacoes ON aplicacoes.id = projetos.aplicacao_id
                                    JOIN projetos.aplicacoes_equipes ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                                  WHERE
                                    data_execucao IS NOT NULL AND
                                    equipe_id = :idEquipe
                                  GROUP BY data_execucao) as execucoes
                            GROUP BY data",['idEquipe' => $idEquipe])
        );
    }
}
