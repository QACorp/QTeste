<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;

interface GraficoFalhasSucessoBusinessContract
{
    public function buscarTotaisFalhasSucesso(int $idEquipe): GraficoFalhasSucessoDTO;
}
