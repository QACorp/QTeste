<?php

namespace App\System\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $message = "404 - Not Found", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
