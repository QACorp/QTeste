<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface CasosTesteMaisFalhasRepositoryContract
{
    public function buscarTotaisTestes(int $limit, int $idEquipe): DataCollection;
}
