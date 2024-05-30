<?php

namespace App\Modules\Retrabalhos\DTOs;
use App\System\Casts\CastEquipes;
use App\System\Casts\CastRoles;
use App\System\DTOs\UserDTO as BaseDTO;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class UserDTO extends BaseDTO
{

    public ?DataCollectable $retrabalhos;

}
