<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastCarbon;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class ProjetoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $nome,
        public ?string $descricao,
        #[WithCast(CastCarbon::class)]
        public ?Carbon $inicio,
        #[WithCast(CastCarbon::class)]
        public ?Carbon $termino,
        public ?int $aplicacao_id
    )
    {
    }
}
