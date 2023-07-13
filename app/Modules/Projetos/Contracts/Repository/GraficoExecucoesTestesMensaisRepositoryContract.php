<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface GraficoExecucoesTestesMensaisRepositoryContract extends BaseRepositoryContract
{
    public function buscarTotaisExecucoes(int $idEquipe): DataCollection;

}
