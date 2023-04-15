<?php

namespace App\System\Component;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\Utils\DTO;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public DTO $registro,
        public string $message,
        public string $route
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.system.component.delete-modal');
    }
}
