<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\Business\TotaisTestesBusinessContract;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TotaisTestes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly TotaisTestesBusinessContract $totaisTestesBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $totaisTeste = $this->totaisTestesBusiness->buscarTotaisTestes(EquipeUtils::equipeUsuarioLogado());

        return view('projetos::Components.totais-testes',compact('totaisTeste'));
    }
}
