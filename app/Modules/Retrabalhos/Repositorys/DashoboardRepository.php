<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\DashboardRepositoryContract;
use App\Modules\Retrabalhos\DTOs\AnualDadosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoAplicacaDadosDTO;
use App\Modules\Retrabalhos\Models\Retrabalho;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class DashoboardRepository implements DashboardRepositoryContract
{

    public function getTotalRetrabalhoPorEquipe(int $idEquipe, int $ano): int
    {
        $retrabalhos = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador'])
            ->select(DB::raw('COUNT(retrabalhos.id) as total'))
            ->join('projetos.aplicacoes', 'retrabalhos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->where(DB::raw('EXTRACT(YEAR FROM retrabalhos.data)'), $ano)
            ->first();
        return $retrabalhos->total;
    }

    public function getTotalRetrabalhoPorEquipePorTarefa(int $idEquipe, int $ano): float
    {
        $retrabalhos = Retrabalho::select(DB::raw(
            '(COUNT(retrabalhos.id)::numeric / (SELECT
                                                 CASE
                                                   WHEN COUNT(DISTINCT (retrabalhos.usuario_id)) = 0 THEN 1
                                                 ELSE COUNT(DISTINCT (retrabalhos.usuario_id))
                                                 END
                                 FROM projetos.retrabalhos
                                          JOIN projetos.aplicacoes ON retrabalhos.aplicacao_id = aplicacoes.id
                                          JOIN projetos.aplicacoes_equipes
                                               ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                                 WHERE
                                       aplicacoes_equipes.equipe_id = ? AND
                                       EXTRACT(YEAR FROM retrabalhos.data) = ? AND
                                       retrabalhos.deleted_at is null)::numeric)::numeric(9,2) as total'
        ))
        ->setBindings([$idEquipe, $ano])
        ->join('projetos.aplicacoes', 'retrabalhos.aplicacao_id', '=', 'aplicacoes.id')
        ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
        ->where('aplicacoes_equipes.equipe_id',$idEquipe)
        ->where(DB::raw('EXTRACT(YEAR FROM retrabalhos.data)'), $ano)
        ->first();
        return $retrabalhos->total;
    }

    public function getTotalRetrabalhoPorEquipePorUsuario(int $idEquipe, int $ano): float
    {
        $retrabalhos = Retrabalho::select(DB::raw(
                '(COUNT(retrabalhos.id)::numeric / (SELECT
                                                 CASE
                                                   WHEN COUNT(DISTINCT (retrabalhos.usuario_id)) = 0 THEN 1
                                                 ELSE COUNT(DISTINCT (retrabalhos.usuario_id))
                                                 END
                                 FROM projetos.retrabalhos
                                          JOIN projetos.aplicacoes ON retrabalhos.aplicacao_id = aplicacoes.id
                                          JOIN projetos.aplicacoes_equipes
                                               ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                                 WHERE
                                       aplicacoes_equipes.equipe_id = ? AND
                                       EXTRACT(YEAR FROM retrabalhos.data) = ? AND
                                       retrabalhos.deleted_at is null)::numeric)::numeric(9,2) as total'
            ))
            ->setBindings([$idEquipe, $ano])
            ->join('projetos.aplicacoes', 'retrabalhos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->where(DB::raw('EXTRACT(YEAR FROM retrabalhos.data)'), $ano)
            ->first();
        return $retrabalhos->total;
    }

    public function getTotaPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        $retrabalhos = DB::select(
            "select
                        EXTRACT(MONTH FROM retrabalhos.data) as mes,
                        COUNT(retrabalhos.id) as total_retrabalho
                    from projetos.retrabalhos
                             inner join projetos.aplicacoes on retrabalhos.aplicacao_id = aplicacoes.id
                             inner join projetos.aplicacoes_equipes on aplicacoes_equipes.aplicacao_id = aplicacoes.id
                    where aplicacoes_equipes.equipe_id = ?
                      and EXTRACT(YEAR FROM retrabalhos.data) = ? and projetos.retrabalhos.deleted_at is null
                    group by mes", [$idEquipe, $ano]);

        return AnualDadosDTO::collection($retrabalhos);
    }

    public function getTotalAplicacaoPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        $retrabalhos = DB::select(
            "select
                        aplicacoes.nome as nome_aplicacao,
                        aplicacoes.id as aplicacao_id,
                        COUNT(retrabalhos.id) as total_retrabalho,
                        EXTRACT(MONTH FROM retrabalhos.data) as mes
                    from projetos.retrabalhos
                             inner join projetos.aplicacoes on retrabalhos.aplicacao_id = aplicacoes.id
                             inner join projetos.aplicacoes_equipes on aplicacoes_equipes.aplicacao_id = aplicacoes.id
                    where aplicacoes_equipes.equipe_id = ?
                      and EXTRACT(YEAR FROM retrabalhos.data) = ? and projetos.retrabalhos.deleted_at is null
                    group by mes, aplicacoes.id, aplicacoes.nome", [$idEquipe, $ano]);

        return RetrabalhoAplicacaDadosDTO::collection($retrabalhos);
    }

    public function getTotalUsuarioPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        $retrabalhos = DB::select(
            "WITH consulta_retrabalhos AS (
                        select
                            ap.nome as nome_aplicacao,
                            ap.id as aplicacao_id,
                            EXTRACT(MONTH FROM retrabalhos.data) as mes,
                            COUNT(retrabalhos.id) as total
                        from projetos.retrabalhos
                                 inner join projetos.aplicacoes ap on retrabalhos.aplicacao_id = ap.id
                                 inner join projetos.aplicacoes_equipes on aplicacoes_equipes.aplicacao_id = ap.id
                        where
                            aplicacoes_equipes.equipe_id = :idEquipe and
                            EXTRACT(YEAR FROM retrabalhos.data) = :ano and
                            projetos.retrabalhos.deleted_at is null
                        group by mes, ap.id, ap.nome
                    )
                    select
                        nome_aplicacao,
                        aplicacao_id,
                        mes,
                        total,
                        (consulta_retrabalhos.total / (SELECT COUNT(DISTINCT (re.usuario_id))
                                                           FROM projetos.retrabalhos as re
                                                                    JOIN projetos.aplicacoes ON re.aplicacao_id = aplicacoes.id
                                                                    JOIN projetos.aplicacoes_equipes
                                                                         ON aplicacoes_equipes.aplicacao_id = aplicacoes.id
                                                           WHERE
                                                               aplicacoes_equipes.equipe_id = :idEquipe AND
                                                               EXTRACT(YEAR FROM re.data) = :ano AND
                                                               EXTRACT(MONTH FROM re.data) = consulta_retrabalhos.mes AND
                                                               aplicacoes.id = consulta_retrabalhos.aplicacao_id AND
                                                               re.deleted_at is null

                                                           )::numeric)::numeric(9,2) as total_retrabalho
                    from consulta_retrabalhos", ['idEquipe'=> $idEquipe, 'ano' => $ano]);

        return RetrabalhoAplicacaDadosDTO::collection($retrabalhos);
    }
}
