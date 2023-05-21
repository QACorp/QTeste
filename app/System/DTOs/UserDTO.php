<?php

namespace App\System\DTOs;

use App\System\Utils\DTO;

class UserDTO extends DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email
    )
    {
    }

}
