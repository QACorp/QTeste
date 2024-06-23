<?php

namespace App\System\DTOs;

use App\System\Casts\CastUsers;
use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;
use Symfony\Contracts\Service\Attribute\Required;

class EmpresaConfiguracaoDTO extends DTO
{
    public ?int $id;
    #[Required]
    public ?string $nome;
    #[Required]
    public ?string $valor;
    public ?bool $valor_criptografado;
    public ?string $descricao;
    #[Required]
    public ?string $prefixo_modulo;
    #[Required]
    public ?int $empresa_id;
}
