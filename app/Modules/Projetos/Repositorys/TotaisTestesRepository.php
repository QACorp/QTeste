<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use Illuminate\Support\Facades\DB;

class TotaisTestesRepository implements TotaisTestesRepositoryContract
{

    public function buscarTotaisTestes(int $idEquipe): TotaisTestesDTO
    {

       return TotaisTestesDTO::from(
            DB::select('SELECT
                (SELECT
                     COUNT(aplicacoes.id)
                 FROM projetos.aplicacoes
                    JOIN projetos.aplicacoes_equipes ON aplicacoes.id = aplicacoes_equipes.aplicacao_id
                 WHERE
                     aplicacoes.deleted_at is null AND
                     equipe_id = :idEquipe
                 ) as total_aplicacoes,
                (SELECT
                     COUNT(planos_teste.id)
                 FROM projetos.planos_teste
                    JOIN projetos.projetos ON projetos.id = planos_teste.projeto_id
                    JOIN projetos.aplicacoes ON aplicacoes.id = projetos.aplicacao_id
                    JOIN projetos.aplicacoes_equipes ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                 WHERE
                     planos_teste.deleted_at is null AND
                     equipe_id = :idEquipe
                ) as total_planos_teste,
                (SELECT
                     COUNT(casos_teste.id)
                 FROM projetos.casos_teste
                    JOIN projetos.casos_teste_equipes ON casos_teste_equipes.caso_teste_id = casos_teste.id
                 WHERE
                     casos_teste.deleted_at is null AND
                     equipe_id = :idEquipe
                ) as total_casos_teste,
                (SELECT
                     COUNT(projetos.id)
                 FROM projetos.projetos
                    JOIN projetos.aplicacoes ON aplicacoes.id = projetos.aplicacao_id
                    JOIN projetos.aplicacoes_equipes ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                 WHERE
                     projetos.deleted_at is null AND
                     equipe_id = :idEquipe
                ) as total_projetos
            ',['idEquipe' => $idEquipe])[0]
        );
    }
}
