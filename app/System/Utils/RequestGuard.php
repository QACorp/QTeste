<?php

namespace App\System\Utils;

abstract class RequestGuard
{
    public readonly string $guard;

    public function getGuard()
    {
        return $this->guard;
    }
}
