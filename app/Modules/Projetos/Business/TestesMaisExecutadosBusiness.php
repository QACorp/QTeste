<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\TestesMaisExecutadosBusinessContract;
use App\Modules\Projetos\Contracts\Repository\TestesMaisExecutadosRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class TestesMaisExecutadosBusiness extends BusinessAbstract implements TestesMaisExecutadosBusinessContract
{
    public function __construct(
        private readonly TestesMaisExecutadosRepositoryContract $testesMaisExecutadosRepository
    )
    {
    }

    public function buscarTestesPorOrdemMaisExecutado(int $limit, int $idEquipe): DataCollection
    {
        return $this->testesMaisExecutadosRepository->buscarTestesPorOrdemMaisExecutado($limit, $idEquipe);
    }
}
