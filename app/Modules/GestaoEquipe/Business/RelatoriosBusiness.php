<?php

namespace App\Modules\GestaoEquipe\Business;

use App\Modules\GestaoEquipe\Contracts\Business\RelatoriosBusinessContract;
use App\Modules\GestaoEquipe\Contracts\Repository\RetrabalhoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\RelatorioRetrabalhosDTO;
use App\Modules\Retrabalhos\Enums\PermissionEnum;
use App\System\Impl\BusinessAbstract;
use Carbon\Carbon;

class RelatoriosBusiness extends BusinessAbstract implements RelatoriosBusinessContract
{

    public function __construct(
        private readonly RetrabalhoRepositoryContract $retrabalhoRepository
    )
    {
    }

    public function buscarRetrabalhosUsuario(int $idUsuario, int $idEquipe, ?Carbon $inicio, ?Carbon $termino): RelatorioRetrabalhosDTO
    {
        $this->can(PermissionEnum::VER_RELATORIO_GESTOR->value);
        return $this->retrabalhoRepository->buscarRetrabalhosUsuario($idUsuario, $idEquipe, $inicio, $termino);
    }
}
