<?php

namespace App\Modules\GestaoEquipe\Contracts\Repository;

use App\Modules\GestaoEquipe\DTOs\RelatorioRetrabalhosDTO;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract as RetrabalhoRepositoryContractBase;
use Carbon\Carbon;

interface RetrabalhoRepositoryContract extends RetrabalhoRepositoryContractBase
{
    public function buscarRetrabalhosUsuario(int $idUsuario, int $idEquipe, ?Carbon $inicio, ?Carbon $termino): RelatorioRetrabalhosDTO;
}
