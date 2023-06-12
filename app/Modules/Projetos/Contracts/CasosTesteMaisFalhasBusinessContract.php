<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasBusinessContract
{
    public function buscarTotaisTestes($limit): DataCollection;
}
