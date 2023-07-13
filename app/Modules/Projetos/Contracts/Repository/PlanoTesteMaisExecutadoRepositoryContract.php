<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteMaisExecutadoRepositoryContract extends BaseRepositoryContract
{
    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit, int $idEquipe): DataCollection;
}
