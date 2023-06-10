<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface PlanoTesteMaisExecutadoBusinessContract
{
    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit): DataCollection;
}
