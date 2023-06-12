<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasRepositoryContract
{
    public function buscarTotaisTestes($limite): DataCollection;
}
