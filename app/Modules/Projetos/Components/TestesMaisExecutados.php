<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\TestesMaisExecutadosBusinessContract;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestesMaisExecutados extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly TestesMaisExecutadosBusinessContract $testesMaisExecutadosBusiness
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
        $casosTeste = $this->testesMaisExecutadosBusiness->buscarTestesPorOrdemMaisExecutado(5);

        return view(
            'projetos::Components.testes-mais-executados',
            compact('config','heads', 'casosTeste')
        );
    }
}
