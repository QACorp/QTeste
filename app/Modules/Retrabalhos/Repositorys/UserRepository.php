<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\UserRepositoryContract;
use App\Modules\Retrabalhos\DTOs\UserDTO;
use App\System\Enums\RoleEnum;
use App\System\Models\User;
use App\System\Repositorys\UserRepository as BaseRepository;
use Spatie\LaravelData\DataCollection;


class UserRepository extends BaseRepository implements UserRepositoryContract
{

    public function listaUsuariosByPermissaoDesenvolvedor(): DataCollection
    {
        return UserDTO::collection(
            User::role(RoleEnum::DESENVOLVEDOR->value)->get()
        );
    }
}
