<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use App\Modules\Projetos\DTOs\TotaisTestesDTO;

interface GraficoFalhasSucessoBusinessContract
{
    public function buscarTotaisFalhasSucesso(): GraficoFalhasSucessoDTO;
}
