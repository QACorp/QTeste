<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\PlanoTesteMaisExecutadoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteMaisExecutadoDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use App\System\Impl\BaseRepository;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class PlanoTesteMaisExecutadoRepository extends BaseRepository  implements PlanoTesteMaisExecutadoRepositoryContract
{

    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit, int $idEquipe): DataCollection
    {
        return PlanoTesteMaisExecutadoDTO::collection(
            PlanoTeste::select(DB::raw('
                       planos_teste.id,
                       titulo,
                       planos_teste.descricao,
                       user_id, projeto_id,
                       projetos.nome as nome_projeto,
                       aplicacoes.nome as nome_aplicacao,
                       planos_teste.created_at,
                       aplicacoes.id as aplicacao_id,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.plano_teste_execucoes pte2
                 WHERE pte2.plano_teste_id = planos_teste.id AND
                 pte2.equipe_id = aplicacoes_equipes.equipe_id) as total_execucoes'))
                ->orderBy('total_execucoes','DESC')
                ->where('equipe_id', $idEquipe)
                ->limit($limit)
                ->get()
        );
    }
}
