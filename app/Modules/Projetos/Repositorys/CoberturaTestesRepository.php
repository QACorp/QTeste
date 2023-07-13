<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\CoberturaTestesRepositoryContract;
use App\Modules\Projetos\DTOs\CoberturaTestesDTO;
use App\Modules\Projetos\Models\Aplicacao;
use App\System\Impl\BaseRepository;
use Spatie\LaravelData\DataCollection;

class CoberturaTestesRepository extends BaseRepository  implements CoberturaTestesRepositoryContract
{

    public function buscarCoberturaTestes(int $idEquipe): DataCollection
    {
        return CoberturaTestesDTO::collection(
            Aplicacao::selectRaw('
                                id,
                                nome,
                                (SELECT
                                    COUNT(ctpt.caso_teste_id)
                                FROM projetos.planos_teste pt
                                         JOIN projetos.caso_teste_plano_teste ctpt on pt.id = ctpt.plano_teste_id
                                         JOIN projetos.projetos on projetos.id = pt.projeto_id
                                         JOIN projetos.aplicacoes as app on aplicacoes.id = projetos.aplicacao_id
                                         JOIN projetos.casos_teste on casos_teste.id = ctpt.caso_teste_id
                                         JOIN projetos.casos_teste_equipes ON casos_teste.id = casos_teste_equipes.caso_teste_id
                                WHERE
                                        app.id = aplicacoes.id AND
                                        casos_teste_equipes.equipe_id = ae.equipe_id AND
                                        pt.deleted_at IS NULL) as total_testes'
            )
                ->join('projetos.aplicacoes_equipes as ae','ae.aplicacao_id', '=', 'aplicacoes.id')
                ->where('equipe_id', $idEquipe)
                ->get()
        );
    }
}
