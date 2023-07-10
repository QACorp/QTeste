<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\Business\PlanoTesteMaisExecutadoBusinessContract;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlanoTesteMaisExecutados extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly PlanoTesteMaisExecutadoBusinessContract $planoTesteMaisExecutadoBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $heads = [
            ['label' => '#', 'width' => 10],
            'Nome',
            ['label' => 'Exec.', 'width' => 5],
            ['label' => 'Ações', 'width' => 10],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'ordering' => false,
            'paging' => false,
            'searching' => false,

        ];
        $planos_teste = $this->planoTesteMaisExecutadoBusiness->buscarPlanosTestePorOrdemMaisExecutado(5, EquipeUtils::equipeUsuarioLogado());
        return view('projetos::Components.plano-teste-mais-executados',
            compact(
                'heads',
                'config',
                'planos_teste'
            ));
    }
}
