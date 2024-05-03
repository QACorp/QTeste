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

    public function getTotalRetrabalhoPorEquipe(int $idEquipe): int
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipe($idEquipe);
    }

    public function getTotalRetrabalhoPorEquipePorTarefa(int $idEquipe): float
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipePorTarefa($idEquipe);
    }

    public function getTotalRetrabalhoPorEquipePorUsuario(int $idEquipe): float
    {
        return $this->dashboardRepository->getTotalRetrabalhoPorEquipePorUsuario($idEquipe);
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
