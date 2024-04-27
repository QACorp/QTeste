<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastSprints;
use App\Modules\GestaoProjetos\Casts\CastTarefas;
use App\Modules\Projetos\Casts\CastAplicacao;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\DTOs\ProjetoDTO as ProjetoBaseDTO;
use App\System\Casts\CastCarbonDate;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class ProjetoDTO extends ProjetoBaseDTO
{

    public ?DataCollectable $retrabalhos;

}
