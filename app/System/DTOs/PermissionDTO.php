<?php

namespace App\System\DTOs;

use App\System\Utils\DTO;

class PermissionDTO extends DTO
{
    public function __construct(
        public string $name,
        public ?int $id,
        public ?string $guard_name
    )
    {
    }
}
