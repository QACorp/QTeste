<?php

namespace App\System\Utils;

class RequestGuardWeb extends RequestGuard
{
    public function __construct(public readonly string $guard = 'web')
    {
    }
}
