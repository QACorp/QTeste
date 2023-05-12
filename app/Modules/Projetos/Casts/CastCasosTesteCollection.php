<?php

namespace App\Modules\Projetos\Casts;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastCasosTesteCollection implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  CasoTesteDTO::collection($value);
    }
}
