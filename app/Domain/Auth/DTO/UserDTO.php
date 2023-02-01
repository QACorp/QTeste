<?php

namespace App\Domain\Auth\DTO;

use App\Application\Abstracts\DTOAbstract;

class UserDTO extends DTOAbstract
{
    public function __construct(
        public ?int $id = null,
        public ?string $name,
        public ?string $email,
        public ?string $password,
    )
    {
    }

}
