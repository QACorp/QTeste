<?php

namespace App\System\Component;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UploadModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $idModal,
        public string $message,
        public string $routeAction,
        public ?string $labelBtnEnviar,

    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app.system.component.upload-modal');
    }
}
