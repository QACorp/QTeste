<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface CoberturaTestesRepositoryContract
{
    public function buscarCoberturaTestes(): DataCollection;
}
