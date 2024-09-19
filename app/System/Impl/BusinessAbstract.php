<?php

namespace App\System\Impl;

use App\System\Exceptions\UnauthorizedException;
use App\System\Traits\RequestGuardTraits;
use App\System\Utils\RequestGuard;
use Illuminate\Support\Facades\Auth;

class BusinessAbstract
{
    use RequestGuardTraits;
    public function can(string $permission, string $guard = 'web'): void
    {
        if(!Auth::guard($this->getGuard())->user()->can($permission)){
            throw new UnauthorizedException(403);
        }
    }

    public function canDo(string $permission, string $guard = 'web'): bool
    {
        return Auth::guard($this->getGuard())->user()->can($permission);
    }
}
