<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\TotaisTestesDTO;

interface TotaisTestesBusinessContract
{
    public function buscarTotaisTestes(int $idEquipe): TotaisTestesDTO;
}
