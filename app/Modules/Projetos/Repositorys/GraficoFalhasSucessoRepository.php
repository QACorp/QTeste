<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\GraficoFalhasSucessoRepositoryContract;
use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use App\System\Impl\BaseRepository;
use Illuminate\Support\Facades\DB;

class GraficoFalhasSucessoRepository extends BaseRepository  implements GraficoFalhasSucessoRepositoryContract
{

    public function buscarTotaisFalhasSucesso(int $idEquipe): GraficoFalhasSucessoDTO
    {

       return GraficoFalhasSucessoDTO::from(
            DB::select("SELECT
                            (SELECT
                                 COUNT(id)
                             FROM projetos.caso_teste_execucoes
                             WHERE
                                 deleted_at is null AND
                                 resultado = 'Passou' AND
                                 equipe_id = :idEquipe
                            ) as passou,
                            (SELECT
                                 COUNT(id)
                             FROM projetos.caso_teste_execucoes
                             WHERE
                                 deleted_at is null AND
                                     resultado = 'Falhou' AND
                                 equipe_id = :idEquipe

                            ) as falhou
                        ",[$idEquipe])[0]
        );
    }
}
