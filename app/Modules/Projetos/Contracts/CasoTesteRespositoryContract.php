<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface CasoTesteRespositoryContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection;
}
