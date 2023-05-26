<?php

namespace App\System\DTOs;

use App\System\Utils\DTO;

class RoleDTO extends DTO
{
    public function __construct(
        public string $name,
        public ?int $id,
        public ?string $guard_name
    )
    {
    }
}
