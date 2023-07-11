<?php

namespace App\System\Casts;

use App\System\DTOs\RoleDTO;
use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastRoles implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {

       return  RoleDTO::collection($value);
    }
}
