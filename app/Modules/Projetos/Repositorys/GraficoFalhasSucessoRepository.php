<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Components\GraficoFalhasSucesso;
use App\Modules\Projetos\Contracts\GraficoFalhasSucessoRepositoryContract;
use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use Illuminate\Support\Facades\DB;

class GraficoFalhasSucessoRepository implements GraficoFalhasSucessoRepositoryContract
{

    public function buscarTotaisFalhasSucesso(): GraficoFalhasSucessoDTO
    {

       return GraficoFalhasSucessoDTO::from(
            DB::select("SELECT
                            (SELECT
                                 COUNT(id)
                             FROM projetos.caso_teste_execucoes
                             WHERE
                                 deleted_at is null AND
                                 resultado = 'Passou'
                            ) as passou,
                            (SELECT
                                 COUNT(id)
                             FROM projetos.caso_teste_execucoes
                             WHERE
                                 deleted_at is null AND
                                     resultado = 'Falhou'
                            ) as falhou
                        ")[0]
        );
    }
}
