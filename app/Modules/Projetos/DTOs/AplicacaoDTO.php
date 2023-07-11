<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastEquipes;
use App\System\DTOs\EquipeDTO;
use App\System\Utils\DTO;
use Spatie\LaravelData\Contracts\DataCollectable;

class AplicacaoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $nome,
        public ?string $descricao,
        #[WithCast(CastEquipes::class)]
        public ?DataCollectable $equipes
    )
    {
    }
}
