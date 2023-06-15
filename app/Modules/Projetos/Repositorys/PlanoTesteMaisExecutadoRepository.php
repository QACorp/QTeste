<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\PlanoTesteMaisExecutadoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteMaisExecutadoDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class PlanoTesteMaisExecutadoRepository implements PlanoTesteMaisExecutadoRepositoryContract
{

    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit): DataCollection
    {
        return PlanoTesteMaisExecutadoDTO::collection(
            PlanoTeste::select(DB::raw('
                       planos_teste.id,
                       titulo,
                       planos_teste.descricao,
                       user_id, projeto_id,
                       p.nome as nome_projeto,
                       a.nome as nome_aplicacao,
                       planos_teste.created_at,
                       a.id as aplicacao_id,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.plano_teste_execucoes pte2
                 WHERE pte2.plano_teste_id = planos_teste.id) as total_execucoes'))
                ->join('projetos.projetos as p', 'planos_teste.projeto_id','=','p.id')
                ->join('projetos.aplicacoes as a', 'p.aplicacao_id','=','a.id')
                ->orderBy('total_execucoes','DESC')
                ->limit($limit)
                ->get()
        );
    }
}
