<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\TotaisTestesDTO;

interface TotaisTestesRepositoryContract
{
    public function buscarTotaisTestes(): TotaisTestesDTO;
}
