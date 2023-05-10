<?php

namespace App\Modules\Projetos\Casts;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Castable;
use Spatie\LaravelData\Support\DataProperty;

class CastProjeto implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  ProjetoDTO::from($value);
    }
}
