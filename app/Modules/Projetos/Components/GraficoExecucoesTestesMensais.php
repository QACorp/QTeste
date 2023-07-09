<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\Business\GraficoExecucoesTestesMensaisBusinessContract;
use App\System\Utils\EquipeUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GraficoExecucoesTestesMensais extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly GraficoExecucoesTestesMensaisBusinessContract $graficoExecucoesTestesMensaisBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $mes = 1;
        $arrayMes = [];
        while ($mes <= date('m')){
            $arrayMes[] = date('Y').'/'.$mes;
            $mes++;
        }

        $dados = $this->graficoExecucoesTestesMensaisBusiness->buscarTotaisExecucoes(EquipeUtils::equipeUsuarioLogado());

        return view(
            'projetos::Components.grafico-execucoes-testes-mensais',
            compact('arrayMes', 'dados'));
    }
}
