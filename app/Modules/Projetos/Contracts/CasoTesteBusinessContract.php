<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface CasoTesteBusinessContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection;
}
