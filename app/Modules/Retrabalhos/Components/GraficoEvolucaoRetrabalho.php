<?php

namespace App\Modules\Retrabalhos\Components;

use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\System\Helpers\DateHelper;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class GraficoEvolucaoRetrabalho extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly int $ano,
        private readonly DashboardBusinessContract $dashboardBusiness
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dadosAnoAnterior = $this->dashboardBusiness->getTotaPorPeriodoAnual(EquipeUtils::equipeUsuarioLogado(), $this->ano - 1);
        $dadosAnoAtual = $this->dashboardBusiness->getTotaPorPeriodoAnual(EquipeUtils::equipeUsuarioLogado(), $this->ano);
        $meses = DateHelper::getCollectionMeses();

        return view('retrabalhos::Components.grafico-evolucao-retrabalho', compact(
            'dadosAnoAnterior',
            'dadosAnoAtual',
            'meses'));
    }
}
