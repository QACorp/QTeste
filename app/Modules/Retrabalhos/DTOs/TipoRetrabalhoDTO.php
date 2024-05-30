<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;


class TipoRetrabalhoDTO extends DTO
{
    public ?int $id;
    public ?string $descricao;
    public ?TipoRetrabalhoEnum $tipo;

}
