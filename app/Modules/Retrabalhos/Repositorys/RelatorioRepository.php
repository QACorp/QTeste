<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\RelatorioRepositoryContract;
use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\DTOs\MeusCadastrosDTO;
use App\Modules\Retrabalhos\DTOs\MeusRetrabalhosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoAplicacaoDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDesenvolvedorDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoTarefaDTO;
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
                                       CASE WHEN tarefas = 0 THEN 0 ELSE (retrabalhos / tarefas)::numeric(9,2) END as proporcao_retrabalho,
                                       CASE WHEN retrabalhos = 0 THEN 0 ELSE (retrabalhos_analise / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_analise,
                                       CASE WHEN retrabalhos = 0 THEN 0 ELSE (retrabalhos_funcionais / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_funcionais
                                FROM
                                    retrabalhos".
                                ($filtrosDTO->idUsuario ? " WHERE id = :idUsuario" : ""), $parameters);
        return RetrabalhoDesenvolvedorDTO::collection($relatorio);

    }

    public function relatorioRetrabalhoTarefa(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $parameters = [
            'idEquipe' => $idEquipe,
            'dataInicio' => $filtrosDTO->dataInicio,
            'dataFim' => $filtrosDTO->dataFim,
        ];
        $relatorio = DB::select("WITH retrabalhos AS (
                                            SELECT
                                                DISTINCT (rt.numero_tarefa),
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                 WHERE
                                                     r.numero_tarefa = rt.numero_tarefa AND
                                                     r.deleted_at IS NULL AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos,
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                          JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                                 WHERE
                                                     r.numero_tarefa = rt.numero_tarefa AND
                                                     tr.tipo = 'Funcional' AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     r.deleted_at IS NULL AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos_funcionais,
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                          JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                                 WHERE
                                                     r.numero_tarefa = rt.numero_tarefa AND
                                                     tr.tipo = 'Análise de código' AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     r.deleted_at IS NULL AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos_analise


                                            FROM
                                                projetos.retrabalhos rt
                                                         JOIN projetos.aplicacoes a ON rt.aplicacao_id = a.id
                                                         JOIN projetos.aplicacoes_equipes ape ON a.id = ape.aplicacao_id
                                            WHERE
                                                ape.equipe_id = :idEquipe AND
                                                rt.data between :dataInicio and :dataFim AND
                                                rt.deleted_at IS NULL
                                        )

                                        SELECT *,
                                               CASE WHEN retrabalhos = 0 THEN 0 ELSE ( retrabalhos_analise / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_analise,
                                               CASE WHEN retrabalhos = 0 THEN 0 ELSE (retrabalhos_funcionais / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_funcionais
                                        FROM
                                            retrabalhos", $parameters);
        return RetrabalhoTarefaDTO::collection($relatorio);

    }

    public function relatorioRetrabalhoAplicacao(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $parameters = [
            'idEquipe' => $idEquipe,
            'dataInicio' => $filtrosDTO->dataInicio,
            'dataFim' => $filtrosDTO->dataFim,
        ];
        $relatorio = DB::select("WITH retrabalhos AS (
                                            SELECT
                                                ap.id as id_aplicacao,
                                                ap.nome,
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                 WHERE
                                                     a.id = ap.id AND
                                                     r.deleted_at IS NULL AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos,
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                          JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                                 WHERE
                                                     a.id = ap.id AND
                                                     tr.tipo = 'Funcional' AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     r.deleted_at IS NULL AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos_funcionais,
                                                (SELECT
                                                     COUNT(r.id)
                                                 FROM projetos.retrabalhos r
                                                          JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                          JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                                          JOIN projetos.tipos_retrabalhos tr ON r.tipo_retrabalho_id = tr.id
                                                 WHERE
                                                     a.id = ap.id AND
                                                     tr.tipo = 'Análise de código' AND
                                                     r.data between :dataInicio and :dataFim AND
                                                     r.deleted_at IS NULL AND
                                                     ae.equipe_id = ape.equipe_id)::numeric as retrabalhos_analise,
                                            (SELECT
                                                 COUNT(DISTINCT (r.numero_tarefa))
                                             FROM projetos.retrabalhos r
                                                      JOIN projetos.aplicacoes a ON r.aplicacao_id = a.id
                                                      JOIN projetos.aplicacoes_equipes ae ON a.id = ae.aplicacao_id
                                             WHERE
                                                 a.id = ap.id AND
                                                 r.data between :dataInicio and :dataFim AND
                                                 r.deleted_at IS NULL AND
                                                 ae.equipe_id = :idEquipe)::numeric as tarefas


                                            FROM
                                                projetos.aplicacoes ap
                                                   JOIN projetos.aplicacoes_equipes ape ON ap.id = ape.aplicacao_id
                                            WHERE
                                                ape.equipe_id = :idEquipe AND
                                                ap.deleted_at IS NULL
                                        )

                                        SELECT *,
                                               CASE WHEN tarefas = 0 THEN 0 ELSE (retrabalhos / tarefas)::numeric(9,2) END as proporcao_retrabalho,
                                               CASE WHEN retrabalhos = 0 THEN 0 ELSE (retrabalhos_analise / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_analise,
                                               CASE WHEN retrabalhos = 0 THEN 0 ELSE (retrabalhos_funcionais / retrabalhos)::numeric(9,2) END as proporcao_retrabalho_funcionais
                                        FROM
                                            retrabalhos", $parameters);
        return RetrabalhoAplicacaoDTO::collection($relatorio);
    }

    public function relatorioMeusRetrabalhos(FiltrosDTO $filtrosDTO,  int $idUser): DataCollection
    {
        $parameters = [
            'dataInicio' => $filtrosDTO->dataInicio,
            'dataFim' => $filtrosDTO->dataFim,
            'idUsuario' => $idUser
        ];
        $relatorio = DB::select("SELECT
                                            retrabalhos.id,
                                            retrabalhos.numero_tarefa,
                                            retrabalhos.data,
                                            aplicacoes.nome as nome_aplicacao,
                                            projetos.nome as nome_projeto,
                                            users.name as nome_criador
                                        FROM
                                            projetos.retrabalhos
                                                JOIN projetos.aplicacoes ON retrabalhos.aplicacao_id = aplicacoes.id
                                                JOIN projetos.projetos ON retrabalhos.projeto_id = projetos.id
                                                JOIN users ON retrabalhos.usuario_criador_id = users.id
                                        WHERE
                                            retrabalhos.usuario_id = :idUsuario AND
                                            retrabalhos.deleted_at IS NULL AND
                                            retrabalhos.data BETWEEN :dataInicio AND :dataFim", $parameters);
        return MeusRetrabalhosDTO::collection($relatorio);
    }

    public function relatorioMeusCadastros(FiltrosDTO $filtrosDTO, int $idUser): DataCollection
    {
        $parameters = [
            'dataInicio' => $filtrosDTO->dataInicio,
            'dataFim' => $filtrosDTO->dataFim,
            'idUsuario' => $idUser
        ];
        $relatorio = DB::select("SELECT
                                            retrabalhos.id,
                                            retrabalhos.numero_tarefa,
                                            retrabalhos.data,
                                            aplicacoes.nome as nome_aplicacao,
                                            projetos.nome as nome_projeto,
                                            users.name as nome
                                        FROM
                                            projetos.retrabalhos
                                                JOIN projetos.aplicacoes ON retrabalhos.aplicacao_id = aplicacoes.id
                                                JOIN projetos.projetos ON retrabalhos.projeto_id = projetos.id
                                                JOIN users ON retrabalhos.usuario_id = users.id
                                        WHERE
                                            retrabalhos.usuario_criador_id = :idUsuario AND
                                            retrabalhos.deleted_at IS NULL AND
                                            retrabalhos.data BETWEEN :dataInicio AND :dataFim", $parameters);
        return MeusCadastrosDTO::collection($relatorio);
    }
}
