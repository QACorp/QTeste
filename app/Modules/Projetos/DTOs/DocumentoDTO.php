<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class DocumentoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $descricao,
        public ?int $projeto_id,
        public ?string $url,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $created_at
    )
    {
    }
}
