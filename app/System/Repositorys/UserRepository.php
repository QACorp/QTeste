<?php

namespace App\System\Repositorys;

use App\System\Contracts\UserRepositoryContract;
use App\System\DTOs\UserDTO;
use App\System\Models\User;
use Spatie\LaravelData\DataCollection;

class UserRepository implements UserRepositoryContract
{

    public function buscarTodos(): DataCollection
    {
        return UserDTO::collection(
            User::with('roles')
            ->get()
        );
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $user = User::where('id', $userId)
                    ->with('roles')
                    ->first();
        return $user ? UserDTO::from($user) : null;
    }
}
