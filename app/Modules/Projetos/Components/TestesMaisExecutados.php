<?php

namespace App\Modules\Projetos\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TestesMaisExecutados extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('projetos::Components.testes-mais-executados');
    }
}
