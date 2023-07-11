<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CasosTesteMaisFalhasBusinessContract;
use App\Modules\Projetos\Contracts\Repository\CasosTesteMaisFalhasRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class CasosTesteMaisFalhasBusiness extends BusinessAbstract implements CasosTesteMaisFalhasBusinessContract
{
    public function __construct(
        private readonly CasosTesteMaisFalhasRepositoryContract $casosTesteMaisFalhasRepository
    )
    {
    }

    public function buscarTotaisTestes(int $limit, int $idEquipe): DataCollection
    {
        return $this->casosTesteMaisFalhasRepository->buscarTotaisTestes($limit, $idEquipe);
    }
}
