<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\Business\GraficoFalhasSucessoBusinessContract;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GraficoFalhasSucesso extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly GraficoFalhasSucessoBusinessContract $graficoFalhasSucessoBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dados = $this->graficoFalhasSucessoBusiness->buscarTotaisFalhasSucesso(EquipeUtils::equipeUsuarioLogado());

        return view('projetos::Components.grafico-falhas-sucesso', compact('dados'));
    }
}
