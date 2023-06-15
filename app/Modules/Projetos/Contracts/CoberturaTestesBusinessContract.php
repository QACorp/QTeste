<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface CoberturaTestesBusinessContract
{
    public function buscarCoberturaTestes(): DataCollection;
}
