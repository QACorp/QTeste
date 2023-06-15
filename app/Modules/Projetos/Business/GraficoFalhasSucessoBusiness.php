<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\GraficoFalhasSucessoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\GraficoFalhasSucessoRepositoryContract;
use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
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
