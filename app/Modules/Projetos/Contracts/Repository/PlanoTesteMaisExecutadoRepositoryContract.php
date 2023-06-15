<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface PlanoTesteMaisExecutadoRepositoryContract
{
    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit): DataCollection;
}
