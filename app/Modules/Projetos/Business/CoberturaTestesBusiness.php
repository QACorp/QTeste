<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CoberturaTestesBusinessContract;
use App\Modules\Projetos\Contracts\CoberturaTestesRepositoryContract;
use App\Modules\Projetos\Contracts\TotaisTestesBusinessContract;
use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
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
