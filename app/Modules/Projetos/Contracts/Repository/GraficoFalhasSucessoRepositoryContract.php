<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;

interface GraficoFalhasSucessoRepositoryContract
{
    public function buscarTotaisFalhasSucesso(int $idEquipe): GraficoFalhasSucessoDTO;

}
