<?php

namespace App\Domain\Auth\DTO;

use App\Application\Abstracts\DTOAbstract;
use App\Domain\Auth\Models\User;

class AuthDTO extends DTOAbstract
{
    public function __construct(
        public readonly ?string $status,
        public readonly ?string $message = null,
        public readonly UserDTO $user,
        public readonly array $authorization

    )
    {
    }

}
