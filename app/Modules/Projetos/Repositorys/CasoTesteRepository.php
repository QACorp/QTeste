<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use Spatie\LaravelData\DataCollection;

class CasoTesteRepository implements CasoTesteRespositoryContract
{

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        return CasoTesteDTO::collection(
            PlanoTeste::find($idPlanoTeste)->casos_teste
        );
    }
}
