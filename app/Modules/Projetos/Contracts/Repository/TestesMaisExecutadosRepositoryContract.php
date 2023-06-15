<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface TestesMaisExecutadosRepositoryContract
{
    public function buscarTestesPorOrdemMaisExecutado(int $limit): DataCollection;

}
