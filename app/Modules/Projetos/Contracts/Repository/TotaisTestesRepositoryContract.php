<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use App\System\Impl\BaseRepositoryContract;

interface TotaisTestesRepositoryContract extends BaseRepositoryContract
{
    public function buscarTotaisTestes(int $idEquipe): TotaisTestesDTO;
}
