<?php

namespace App\Modules\Retrabalhos\Components;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\System\Helpers\DateHelper;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class GraficoEvolucaoRetrabalhoUsuario extends Component
{

    public function __construct(
        public int $ano,
        private readonly DashboardBusinessContract $dashboardBusiness,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $dadosAnoAtual = $this->dashboardBusiness->getTotalUsuarioPorPeriodoAnual(EquipeUtils::equipeUsuarioLogado(), $this->ano);
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos(EquipeUtils::equipeUsuarioLogado());
        $meses = DateHelper::getCollectionMeses();

        return view('retrabalhos::Components.grafico-evolucao-retrabalho-usuario', compact(
            'dadosAnoAtual',
            'aplicacoes',
            'meses'
        ));
    }
}
