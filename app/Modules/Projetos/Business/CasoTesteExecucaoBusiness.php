<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoBusiness implements CasoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly CasoTesteExecucaoRepositoryContract $planoTesteExecucaoRepository
    )
    {
    }


}
