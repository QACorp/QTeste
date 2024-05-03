<?php

namespace App\Modules\Retrabalhos\Business;

use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\DashboardRepositoryContract;
use Spatie\LaravelData\DataCollection;

class DashboardBusiness implements DashboardBusinessContract
{
    public function __construct(
        private readonly DashboardRepositoryContract $dashboardRepository
    )
    {
    }

    public function getTotalRetrabalhoPorEquipe(int $idEquipe, int $ano): int
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipe($idEquipe, $ano);
    }

    public function getTotalRetrabalhoPorEquipePorTarefa(int $idEquipe, int $ano): float
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipePorTarefa($idEquipe, $ano);
    }

    public function getTotalRetrabalhoPorEquipePorUsuario(int $idEquipe, int $ano,): float
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipePorUsuario($idEquipe, $ano);
    }

    public function getTotaPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        return $this->dashboardRepository->getTotaPorPeriodoAnual($idEquipe, $ano);
    }

    public function getTotalAplicacaoPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        return $this->dashboardRepository->getTotalAplicacaoPorPeriodoAnual($idEquipe, $ano);
    }

    public function getTotalUsuarioPorPeriodoAnual(int $idEquipe, int $ano): DataCollection
    {
        return $this->dashboardRepository->getTotalUsuarioPorPeriodoAnual($idEquipe, $ano);
    }
}
