<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Utils\DTO;
use Carbon\Carbon;

class FiltrosDTO extends DTO
{
    public ?Carbon $dataInicio;
    public ?Carbon $dataFim;
    public ?int $idUsuario = null;
}
