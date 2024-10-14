<?php

namespace App\Modules\GestaoEquipe\Contracts\Business;

use App\Modules\GestaoEquipe\DTOs\RelatorioRetrabalhosDTO;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

interface RelatoriosBusinessContract
{
    public function buscarRetrabalhosUsuario(int $idUsuario, int $idEquipe, ?Carbon $inicio, ?Carbon $termino): RelatorioRetrabalhosDTO;
}
