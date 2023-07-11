<?php

namespace App\Modules\Projetos\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\Modules\Projetos\Casts\CastProjeto;
use App\System\Casts\CastCarbonDateTime;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;
use Spatie\LaravelData\DataCollection;

class ConsultaPlanoTesteDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $descricao,
        public ?int $user_id,
        public ?int $projeto_id,
        public ?string $nome_projeto,
        public ?string $nome_aplicacao,
        public ?int $aplicacao_id,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $created_at,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $ultima_execucao
    )
    {
    }
}
