<?php

namespace App\Modules\Projetos\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\Modules\Projetos\Casts\CastPlanoTeste;
use App\Modules\Projetos\Casts\CastProjeto;
use App\System\Casts\CastCarbonDateTime;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?CasoTesteDTO $caso_teste,
        public ?PlanoTesteExecucaoDTO $plano_teste_execucao,
        public ?string $resultado,
        #[WithCast(CastCarbonDateTime::class)]
        public ?Carbon $data_execucao,
        public ?int $user_id
    )
    {
    }
}
