<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CoberturaTestesBusinessContract;
use App\Modules\Projetos\Contracts\Repository\CoberturaTestesRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class CoberturaTestesBusiness extends BusinessAbstract implements CoberturaTestesBusinessContract
{
    public function __construct(
        private readonly CoberturaTestesRepositoryContract $coberturaTestesRepository
    )
    {
    }


    public function buscarCoberturaTestes(): DataCollection
    {
        return $this->coberturaTestesRepository->buscarCoberturaTestes();
    }
}
