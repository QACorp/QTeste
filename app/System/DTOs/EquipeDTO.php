<?php

namespace App\System\DTOs;

use App\System\Casts\CastRoles;
use App\System\Casts\CastUsers;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class EquipeDTO extends DTO
{
    public ?int $id;
    public ?string $nome;
    public ?int $empresa_id;
    #[WithCast(CastUsers::class)]
    public ?DataCollectable $users;
    public ?EmpresaDTO $empresa;
}
