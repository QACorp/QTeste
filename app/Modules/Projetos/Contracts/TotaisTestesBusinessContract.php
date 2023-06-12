<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\TotaisTestesDTO;

interface TotaisTestesBusinessContract
{
    public function buscarTotaisTestes(): TotaisTestesDTO;
}
