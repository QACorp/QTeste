<?php

namespace App\System\DTOs;

use App\System\Casts\CastUsers;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class EmpresaDTO extends DTO
{
    public ?int $id;
    public ?string $nome;
    public ?int $usuarios;
    #[WithCast(CastUsers::class)]
    public ?DataCollectable $users;
}
