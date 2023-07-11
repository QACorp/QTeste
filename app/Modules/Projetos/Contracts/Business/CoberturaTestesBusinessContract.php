<?php

namespace App\Modules\Projetos\Contracts\Business;

use Spatie\LaravelData\DataCollection;

interface CoberturaTestesBusinessContract
{
    public function buscarCoberturaTestes(int $idEquipe): DataCollection;
}
