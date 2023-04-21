<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Casts\CastCarbonDate;
use App\System\Casts\CastCarbonDateTime;
use App\System\Models\User;
use App\System\UserDTO;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class ObservacaoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $descricao,
        #[WithCast(User::class)]
        public ?UserDTO $user,
        public ?int $user_id,
        public ?int $projeto_id,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $created_at
    )
    {
    }
}
