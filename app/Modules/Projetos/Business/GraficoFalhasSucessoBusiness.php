<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\GraficoFalhasSucessoBusinessContract;
use App\Modules\Projetos\Contracts\GraficoFalhasSucessoRepositoryContract;
use App\Modules\Projetos\Contracts\TotaisTestesBusinessContract;
use App\Modules\Projetos\Contracts\TotaisTestesRepositoryContract;
use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;
use App\System\Impl\BusinessAbstract;

class GraficoFalhasSucessoBusiness extends BusinessAbstract implements GraficoFalhasSucessoBusinessContract
{
    public function __construct(
        private readonly GraficoFalhasSucessoRepositoryContract $graficoFalhasSucessoRepository
    )
    {
    }


    public function buscarTotaisFalhasSucesso(): GraficoFalhasSucessoDTO
    {
        return $this->graficoFalhasSucessoRepository->buscarTotaisFalhasSucesso();
    }
}
