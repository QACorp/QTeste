<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\GraficoExecucoesTestesMensaisBusinessContract;
use App\Modules\Projetos\Contracts\Business\TestesMaisExecutadosBusinessContract;
use App\Modules\Projetos\Contracts\Repository\GraficoExecucoesTestesMensaisRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\TestesMaisExecutadosRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class GraficoExecucoesTestesMensaisBusiness extends BusinessAbstract implements GraficoExecucoesTestesMensaisBusinessContract
{
    public function __construct(
        private readonly GraficoExecucoesTestesMensaisRepositoryContract $graficoExecucoesTestesMensaisRepository
    )
    {
    }

    public function buscarTotaisExecucoes(): DataCollection
    {
        return $this->graficoExecucoesTestesMensaisRepository->buscarTotaisExecucoes();
    }
}
