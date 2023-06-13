<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use Spatie\LaravelData\DataCollection;

interface GraficoFalhasSucessoRepositoryContract
{
    public function buscarTotaisFalhasSucesso(): GraficoFalhasSucessoDTO;

}
