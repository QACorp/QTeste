<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\TestesMaisExecutadosDTO;
use App\System\Utils\DTO;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CasoTesteDetalhes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public CasoTesteDTO|TestesMaisExecutadosDTO $registro
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('projetos::Components.caso-teste-detalhes');
    }
}
