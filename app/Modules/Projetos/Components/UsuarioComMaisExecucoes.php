<?php

namespace App\Modules\Projetos\Components;

use App\Modules\Projetos\Contracts\UsuarioComMaisExecucoesBusinessContract;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UsuarioComMaisExecucoes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly UsuarioComMaisExecucoesBusinessContract $usuarioComMaisExecucoesBusiness
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
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'ordering' => false,
            'paging' => false,
            'searching' => false,

        ];
        $users = $this->usuarioComMaisExecucoesBusiness->buscarUsuarioPorOrdemExecucao(5);
        return view(
            'projetos::Components.usuario-com-mais-execucoes',
            compact('users', 'heads', 'config')
        );
    }
}
