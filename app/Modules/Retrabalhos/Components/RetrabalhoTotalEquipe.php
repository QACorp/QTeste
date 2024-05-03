<?php

namespace App\Modules\Retrabalhos\Components;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\TestesMaisExecutadosDTO;
use App\Modules\Projetos\DTOs\TestesMaisFalhasDTO;
use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\System\Traits\EquipeTools;
use App\System\Utils\DTO;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RetrabalhoTotalEquipe extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(
        public ?int $ano = null,
        private readonly DashboardBusinessContract $dashboardBusiness
    )
    {
        if($this->ano === null) {
            $this->ano = date('Y');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $totalRetrabalho = $this->dashboardBusiness->getTotalRetrabalhoPorEquipe(EquipeUtils::equipeUsuarioLogado(), $this->ano);
        $totalRetrabalhoPorEquipeDesenvolvedor = $this->dashboardBusiness->getTotalRetrabalhoPorEquipePorUsuario(EquipeUtils::equipeUsuarioLogado(), $this->ano);
        $totalRetrabalhoPorEquipeTarefa = $this->dashboardBusiness->getTotalRetrabalhoPorEquipePorTarefa(EquipeUtils::equipeUsuarioLogado(), $this->ano);
        return view('retrabalhos::Components.retrabalho-total-equipe', compact(
            'totalRetrabalho',
            'totalRetrabalhoPorEquipeTarefa',
            'totalRetrabalhoPorEquipeDesenvolvedor'
        ));
    }
}
