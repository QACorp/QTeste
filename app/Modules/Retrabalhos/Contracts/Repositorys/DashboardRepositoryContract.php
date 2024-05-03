<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use Spatie\LaravelData\DataCollection;

interface DashboardRepositoryContract
{
    public function getTotalRetrabalhoPorEquipe(int $idEquipe): int;
    public function getTotalRetrabalhoPorEquipePorTarefa(int $idEquipe): float;
    public function getTotalRetrabalhoPorEquipePorUsuario(int $idEquipe): float;
    public function getTotaPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
    public function getTotalAplicacaoPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
    public function getTotalUsuarioPorPeriodoAnual(int $idEquipe, int $ano): DataCollection;
}
