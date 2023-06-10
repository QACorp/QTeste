<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface PlanoTesteMaisExecutadoRepositoryContract
{
    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit): DataCollection;
}
