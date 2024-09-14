<?php

namespace App\System\Traits;

use App\System\Utils\RequestGuard;
use Illuminate\Support\Facades\App;

trait RequestGuardTraits
{
    public function getGuard()
    {
        $guard = App::make(RequestGuard::class);
        return $guard->getGuard();
    }
}
