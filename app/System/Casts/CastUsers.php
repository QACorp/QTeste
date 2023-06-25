<?php

namespace App\System\Casts;

use App\System\DTOs\RoleDTO;
use App\System\DTOs\UserDTO;
use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CastUsers implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {

       return  UserDTO::collection($value);
    }
}
