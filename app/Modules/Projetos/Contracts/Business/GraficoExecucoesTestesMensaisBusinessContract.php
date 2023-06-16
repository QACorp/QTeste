<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\GraficoFalhasSucessoDTO;
use Spatie\LaravelData\DataCollection;

interface GraficoExecucoesTestesMensaisBusinessContract
{
    public function buscarTotaisExecucoes(): DataCollection;
}
