<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\CoberturaTestesRepositoryContract;
use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\CoberturaTestesDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use App\Modules\Projetos\Models\Aplicacao;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class CoberturaTestesRepository implements CoberturaTestesRepositoryContract
{

    public function buscarCoberturaTestes(): DataCollection
    {
        return CoberturaTestesDTO::collection(
            Aplicacao::selectRaw('
                                id,
                                nome,
                                (SELECT
                                     COUNT(ctpt.caso_teste_id)
                                 FROM projetos.planos_teste pt
                                    JOIN projetos.caso_teste_plano_teste ctpt on pt.id = ctpt.plano_teste_id
                                 WHERE
                                     pt.projeto_id = aplicacoes.id AND
                                     pt.deleted_at IS NULL) as total_testes'
            )->get()
        );
    }
}
