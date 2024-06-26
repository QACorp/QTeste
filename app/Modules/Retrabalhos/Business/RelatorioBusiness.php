<?php

namespace App\Modules\Retrabalhos\Business;

use App\Modules\Retrabalhos\Contracts\Business\RelatorioBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RelatorioRepositoryContract;
use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\Enums\PermissionEnum;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class RelatorioBusiness extends BusinessAbstract implements RelatorioBusinessContract
{
    public function __construct(
        private readonly RelatorioRepositoryContract $relatorioRepository
    )
    {
    }

    public function relatorioRetrabalhoDesenvolvedor(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::VER_RELATORIO_GESTOR->value);
        return $this->relatorioRepository->relatorioRetrabalhoDesenvolvedor($filtrosDTO, $idEquipe);
    }

    public function relatorioRetrabalhoTarefa(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::VER_RELATORIO_GESTOR->value);
        return $this->relatorioRepository->relatorioRetrabalhoTarefa($filtrosDTO, $idEquipe);
    }

    public function relatorioRetrabalhoAplicacao(FiltrosDTO $filtrosDTO, int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::VER_RELATORIO_GESTOR->value);
        return $this->relatorioRepository->relatorioRetrabalhoAplicacao($filtrosDTO, $idEquipe);
    }

    public function relatorioMeusRetrabalhos(FiltrosDTO $filtrosDTO, int $idUser): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_MEUS_RETRABALHOS->value);
        return $this->relatorioRepository->relatorioMeusRetrabalhos($filtrosDTO, $idUser);
    }

    public function relatorioMeusCadastros(FiltrosDTO $filtrosDTO, int $idUser): DataCollection
    {
        $this->can(PermissionEnum::VER_RELATORIO_AUDITOR->value);
        return $this->relatorioRepository->relatorioMeusCadastros($filtrosDTO, $idUser);
    }
}
