<?php

namespace App\Modules\Projetos\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\Modules\Projetos\Casts\CastPlanoTeste;
use App\Modules\Projetos\Casts\CastProjeto;
use App\System\Casts\CastCarbonDateTime;
use App\System\UserDTO;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?PlanoTesteDTO $plano_teste,
        public ?string $resultado,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $created_at,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $data_execucao,
        public ?UserDTO $user

    )
    {
    }
}
