<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface TestesMaisExecutadosRepositoryContract extends BaseRepositoryContract
{
    public function buscarTestesPorOrdemMaisExecutado(int $limit, int $idEquipe): DataCollection;

}
