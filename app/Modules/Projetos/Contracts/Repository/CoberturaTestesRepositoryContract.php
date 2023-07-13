<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface CoberturaTestesRepositoryContract extends BaseRepositoryContract
{
    public function buscarCoberturaTestes(int $idEquipe): DataCollection;
}
