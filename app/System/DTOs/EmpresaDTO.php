<?php

namespace App\System\DTOs;

use App\System\Casts\CastUsers;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;
use Symfony\Contracts\Service\Attribute\Required;

class EmpresaDTO extends DTO
{
    public ?int $id;
    #[Required]
    public ?string $nome;
    public ?int $usuarios;
    #[WithCast(CastUsers::class)]
    public ?DataCollectable $users;
}
