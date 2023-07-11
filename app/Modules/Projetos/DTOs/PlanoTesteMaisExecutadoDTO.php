<?php

namespace App\Modules\Projetos\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\Modules\Projetos\Casts\CastProjeto;
use App\System\Casts\CastCarbonDateTime;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class PlanoTesteMaisExecutadoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $descricao,
        public ?string $nome_aplicacao,
        public ?string $nome_projeto,
        public ?int $user_id,
        public ?int $projeto_id,
        public ?int $aplicacao_id,
        public ?int $total_execucoes

    )
    {
    }
}
