<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasRepositoryContract
{
    public function buscarTotaisTestes($limite): DataCollection;
}
