<?php

namespace App\Modules\Projetos\DTOs;

use App\Modules\Projetos\Casts\CastProjeto;
use App\System\Casts\CastCarbonDateTime;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;

class PlanoTesteDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $descricao,
        public ?int $user_id,
        public ?int $projeto_id,
        #[WithCast(CastProjeto::class)]
        public ?ProjetoDTO $projeto,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $created_at,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $ultima_execucao
    )
    {
    }
}
