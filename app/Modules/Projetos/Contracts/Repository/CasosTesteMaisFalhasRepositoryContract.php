<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasRepositoryContract extends BaseRepositoryContract
{
    public function buscarTotaisTestes(int $limit, int $idEquipe): DataCollection;
}
