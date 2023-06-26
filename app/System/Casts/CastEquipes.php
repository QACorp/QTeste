<?php

namespace App\System\Casts;

use App\System\DTOs\EquipeDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastEquipes implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {

       return  EquipeDTO::collection($value);
    }
}
