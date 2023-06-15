<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\PlanoTesteMaisExecutadoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteMaisExecutadoRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class PlanoTesteMaisExecutadoBusiness extends BusinessAbstract implements PlanoTesteMaisExecutadoBusinessContract
{
    public function __construct(
        private readonly PlanoTesteMaisExecutadoRepositoryContract $planoTesteMaisExecutadoRepository
    )
    {
    }

    public function buscarPlanosTestePorOrdemMaisExecutado(int $limit): DataCollection
    {
        return $this->planoTesteMaisExecutadoRepository->buscarPlanosTestePorOrdemMaisExecutado($limit);
    }
}
