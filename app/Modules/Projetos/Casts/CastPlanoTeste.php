<?php

namespace App\Modules\Projetos\Casts;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastPlanoTeste implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return  PlanoTesteDTO::from($value);
    }
}
