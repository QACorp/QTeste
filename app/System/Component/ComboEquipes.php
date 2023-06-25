<?php

namespace App\System\Component;

use App\System\Business\EquipeBusiness;
use App\System\Contracts\Business\EquipeBusinessContract;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComboEquipes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $idsEquipe,
        private EquipeBusinessContract $equipeBusiness
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $equipes = $this->equipeBusiness->buscarTodos();

        return view(
            'components.app.system.component.combo-equipes',
            compact('equipes')
        );
    }
}
