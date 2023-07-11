<?php

namespace App\System\Exceptions;

use Exception;

class ConflictException extends Exception
{
    public function __construct(string $message = "409 - Conflict", int $code = 409)
    {
        parent::__construct($message, $code);
    }
}
