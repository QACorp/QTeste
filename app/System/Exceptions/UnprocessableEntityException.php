<?php

namespace App\System\Exceptions;

use Exception;
use Illuminate\Validation\Validator;

class UnprocessableEntityException extends Exception
{
    private Validator $validator;
    public function __construct(Validator $validator = null, string $message = "422 - Unprocessable Entity", int $code = 422)
    {
        $this->validator = $validator;
        parent::__construct($message, $code);
    }

    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }

}
