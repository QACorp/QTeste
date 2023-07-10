<?php

namespace App\Modules\Projetos\Contracts\Business;

use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasBusinessContract
{
    public function buscarTotaisTestes(int $limit, int $idEquipe): DataCollection;
}
