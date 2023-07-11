<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastCarbonDateTime;
use App\System\Casts\CastEquipe;
use App\System\Casts\CastEquipes;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

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
        public ?UserDTO $user,
        #[WithCast(CastEquipe::class)]
        public ?EquipeDTO $equipe

    )
    {
    }
}
