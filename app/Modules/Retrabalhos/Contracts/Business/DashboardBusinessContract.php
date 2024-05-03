<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use Spatie\LaravelData\DataCollection;

interface DashboardBusinessContract
{
    public function getTotalRetrabalhoPorEquipe(int $idEquipe): int;
    public function getTotalRetrabalhoPorEquipePorTarefa(int $idEquipe): float;
    public function getTotalRetrabalhoPorEquipePorUsuario(int $idEquipe): float;

    public function getTotaPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
    public function getTotalAplicacaoPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
    public function getTotalUsuarioPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
}
