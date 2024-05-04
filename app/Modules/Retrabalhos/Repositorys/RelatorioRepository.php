<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\RelatorioRepositoryContract;
use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDesenvolvedorDTO;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class RelatorioRepository implements RelatorioRepositoryContract
{

    public function relatorioRetrabalhoDesenvolvedor(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $parameters = [
            'idEquipe' => $idEquipe,
            'dataInicio' => $filtrosDTO->dataInicio,
            'dataFim' => $filtrosDTO->dataFim,
        ];
        if($filtrosDTO->idUsuario){
            $parameters['idUsuario'] = $filtrosDTO->idUsuario;
        }
        $relatorio = DB::select("WITH retrabalhos AS (
                                    SELECT
                                        users.id,
                                        users.name,
                                        (SELECT
                                             COUNT(r.id)
                                         FROM projetos.retrabalhos r
                                                  JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                  JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                         WHERE
                                             r.usuario_id = users.id AND
                                             r.deleted_at IS NULL AND
                                             r.data between :dataInicio and :dataFim AND
                                             ae.equipe_id = :idEquipe)::numeric as retrabalhos,
                                        (SELECT
                                             COUNT(r.id)
                                         FROM projetos.retrabalhos r
                                                  JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                  JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                  JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                         WHERE
                                             r.usuario_id = users.id AND
                                             tr.tipo = 'Funcional' AND
                                             r.data between :dataInicio and :dataFim AND
                                             r.deleted_at IS NULL AND
                                             ae.equipe_id = :idEquipe)::numeric as retrabalhos_funcionais,
                                        (SELECT
                                             COUNT(r.id)
                                         FROM projetos.retrabalhos r
                                                  JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                  JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                  JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                         WHERE
                                             r.usuario_id = users.id AND
                                             tr.tipo = 'Análise de código' AND
                                             r.data between :dataInicio and :dataFim AND
                                             r.deleted_at IS NULL AND
                                             ae.equipe_id = :idEquipe)::numeric as retrabalhos_analise,

                                        (SELECT
                                             COUNT(DISTINCT (r.numero_tarefa))
                                         FROM projetos.retrabalhos r
                                                  JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                  JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                         WHERE
                                             r.usuario_id = users.id AND
                                             r.data between :dataInicio and :dataFim AND
                                             r.deleted_at IS NULL AND
                                             ae.equipe_id = :idEquipe)::numeric as tarefas
                                    FROM
                                        users
                                            JOIN users_equipes ue ON ue.user_id = users.id
                                            JOIN model_has_roles mr ON mr.model_id = user_id
                                            JOIN roles r ON r.id = mr.role_id
                                    WHERE
                                        ue.equipe_id = :idEquipe AND
                                        r.name = 'DESENVOLVEDOR'
                                )

                                SELECT *,
                                       CASE WHEN tarefas = 0 THEN 0 ELSE (retrabalhos / greatest(tarefas,1))::numeric(9,2) END as proporcao_retrabalho,
                                       CASE WHEN retrabalhos_analise = 0 THEN 0 ELSE (retrabalhos_analise / greatest(retrabalhos,1))::numeric(9,2) END as proporcao_retrabalho_analise,
                                       CASE WHEN retrabalhos_funcionais = 0 THEN 0 ELSE (retrabalhos_funcionais / greatest(retrabalhos,1))::numeric(9,2) END as proporcao_retrabalho_funcionais
                                FROM
                                    retrabalhos".
                                ($filtrosDTO->idUsuario ? " WHERE id = :idUsuario" : ""), $parameters);
        return RetrabalhoDesenvolvedorDTO::collection($relatorio);

    }
}
