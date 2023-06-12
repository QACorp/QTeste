<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\CasosTesteMaisFalhasBusinessContract;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CasosTesteComMaisFalhas extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly CasosTesteMaisFalhasBusinessContract $casosTesteMaisFalhasBusiness
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
            ['label' => 'Falhas', 'width' => 5],
            ['label' => 'Ações', 'width' => 10],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'ordering' => false,
            'paging' => false,
            'searching' => false,

        ];
        $casosTesteFalha = $this->casosTesteMaisFalhasBusiness->buscarTotaisTestes(5);

        return view(
            'projetos::Components.casos-teste-com-mais-falhas',
            compact('config','heads', 'casosTesteFalha')
        );
    }
}
