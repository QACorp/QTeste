<?php

namespace App\Modules\Retrabalhos\Models;
use App\Modules\Retrabalhos\DTOs\UserDTO;
use App\System\Models\User as BaseModel;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class User extends BaseModel  implements Cast
{
    public function retrabalhos()
    {
        return $this->hasMany(Retrabalho::class, 'id_usuario');
    }
    public function retrabalhosCriador()
    {
        return $this->hasMany(Retrabalho::class, 'id_usuario_criador');
    }
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return UserDTO::from($value);
    }

}
