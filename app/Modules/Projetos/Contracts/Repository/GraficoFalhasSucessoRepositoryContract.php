<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use App\System\Impl\BaseRepositoryContract;

interface GraficoFalhasSucessoRepositoryContract extends BaseRepositoryContract
{
    public function buscarTotaisFalhasSucesso(int $idEquipe): GraficoFalhasSucessoDTO;

}
