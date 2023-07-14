<?php

namespace App\System\Component;

use App\System\Business\EquipeBusiness;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\DTOs\EquipeDTO;
use App\System\Enums\PermissionEnum;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Spatie\LaravelData\DataCollection;

class ComboEquipes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $idsEquipe = [],
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

        if(Auth::user()->can(PermissionEnum::VINCULAR_EQUIPE->value)){
            $equipes = $this->equipeBusiness->buscarTodos();
        }else{
            $equipes = EquipeDTO::collection(Auth::user()->equipes()->get());
        }
        return view(
            'components.app.system.component.combo-equipes',
            compact('equipes')
        );
    }
}
