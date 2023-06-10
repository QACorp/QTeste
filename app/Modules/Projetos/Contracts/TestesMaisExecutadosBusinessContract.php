<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface TestesMaisExecutadosBusinessContract
{
    public function buscarTestesPorOrdemMaisExecutado(int $limit): DataCollection;
}
