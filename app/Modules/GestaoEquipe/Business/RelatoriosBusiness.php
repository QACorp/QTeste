<?php

namespace App\Modules\GestaoEquipe\Business;

use App\Modules\GestaoEquipe\Contracts\Business\RelatoriosBusinessContract;
use App\Modules\GestaoEquipe\Contracts\Repository\RetrabalhoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\RelatorioRetrabalhosDTO;
use Carbon\Carbon;

class RelatoriosBusiness implements RelatoriosBusinessContract
{
    public function __construct(
        private readonly RetrabalhoRepositoryContract $retrabalhoRepository
    )
    {
    }

    public function buscarRetrabalhosUsuario(int $idUsuario, int $idEquipe, ?Carbon $inicio, ?Carbon $termino): RelatorioRetrabalhosDTO
    {
        return $this->retrabalhoRepository->buscarRetrabalhosUsuario($idUsuario, $idEquipe, $inicio, $termino);
    }
}
