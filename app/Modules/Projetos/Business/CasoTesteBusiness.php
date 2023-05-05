<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use Spatie\LaravelData\DataCollection;

class CasoTesteBusiness implements CasoTesteBusinessContract
{
    public function __construct(
        private readonly CasoTesteRespositoryContract $casoTesteRespository
    )
    {
    }

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        return $this->casoTesteRespository->buscarCasoTestePorPlanoTeste($idPlanoTeste);
    }
}
