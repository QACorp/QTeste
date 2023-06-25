<?php

namespace App\System\DTOs;

use App\System\Casts\CastRoles;
use App\System\Casts\CastUsers;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class EquipeDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $nome,
        #[WithCast(CastUsers::class)]
        public ?DataCollectable $users,
    )
    {
    }
}
