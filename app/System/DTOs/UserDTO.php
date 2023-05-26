<?php

namespace App\System\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\System\Casts\CastRoles;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class UserDTO extends DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password,
        #[WithCast(CastRoles::class)]
        public ?DataCollectable $roles,
    )
    {
    }

}
