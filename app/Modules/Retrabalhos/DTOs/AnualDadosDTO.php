<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Utils\DTO;

class AnualDadosDTO extends DTO
{
    public ?int $ano;
    public ?int $mes;
    public ?string $periodo;
    public ?int $total_retrabalho;

}
