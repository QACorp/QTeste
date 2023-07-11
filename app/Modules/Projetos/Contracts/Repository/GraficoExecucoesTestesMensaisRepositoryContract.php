<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface GraficoExecucoesTestesMensaisRepositoryContract
{
    public function buscarTotaisExecucoes(int $idEquipe): DataCollection;

}
