<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\DTOs\UserDTO;
use App\Modules\Retrabalhos\Models\User;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\Repositorys\UserRepository as BaseRepository;


class UserRepository extends BaseRepository implements UserRepositoryContract
{
    public function buscarPorId(int $userId): ?UserDTO
    {
        $user = User::where('id', $userId)
                    ->with(['roles','integracao'])
                    ->first();

        if($user != null){
            $userDTO = UserDTO::from($user);
            $userDTO->equipes = EquipeDTO::collection($user->equipes);
            return $userDTO;
        }
        return null;
    }

}
