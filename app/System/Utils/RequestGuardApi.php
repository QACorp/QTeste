<?php

namespace App\System\Utils;

class RequestGuardApi extends RequestGuard
{
    public function __construct(public readonly string $guard = 'api')
    {
    }
}
