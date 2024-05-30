<?php

namespace App\Modules\Retrabalhos\Models;

use App\Modules\Projetos\Models\Projeto as BaseModel;
use App\Modules\Retrabalhos\DTOs\ProjetoDTO;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class Projeto extends BaseModel implements Cast
{
    public function retrabalhos()
    {
        return $this->hasMany(Retrabalho::class, 'projeto_id');
    }

    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return ProjetoDTO::from($value);
    }
}
