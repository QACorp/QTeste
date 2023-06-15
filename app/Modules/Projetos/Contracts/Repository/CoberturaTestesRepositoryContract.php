<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface CoberturaTestesRepositoryContract
{
    public function buscarCoberturaTestes(): DataCollection;
}
