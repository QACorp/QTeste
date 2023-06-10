<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Components\TestesMaisExecutados;
use App\Modules\Projetos\Contracts\TestesMaisExecutadosBusinessContract;
use App\Modules\Projetos\Contracts\TestesMaisExecutadosRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class TestesMaisExecutadosBusiness extends BusinessAbstract implements TestesMaisExecutadosBusinessContract
{
    public function __construct(
        private readonly TestesMaisExecutadosRepositoryContract $testesMaisExecutadosRepository
    )
    {
    }

    public function buscarTestesPorOrdemMaisExecutado(int $limit): DataCollection
    {
        return $this->testesMaisExecutadosRepository->buscarTestesPorOrdemMaisExecutado($limit);
    }
}
