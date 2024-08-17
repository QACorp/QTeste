<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\GestaoProjetos\Casts\CastSprints;
use App\Modules\GestaoProjetos\Casts\CastTarefas;
use App\Modules\Projetos\DTOs\ProjetoDTO as ProjetoBaseDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

class ProjetoDTO extends ProjetoBaseDTO
{

    public ?DataCollectable $retrabalhos;

}
