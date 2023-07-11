<?php

namespace App\System\Exceptions;

use Spatie\Permission\Exceptions\UnauthorizedException as ACLUnauthorizationException;

class UnauthorizedException extends ACLUnauthorizationException
{
    public function __construct(int $statusCode, string $message = '', \Throwable $previous = null, array $headers = [], int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

}
