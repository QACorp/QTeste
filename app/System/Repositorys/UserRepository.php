<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\UserRepositoryContract;
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

    public function alterar(UserDTO $userDTO): UserDTO
    {

        $user = User::find($userDTO->id);
        if(empty($userDTO->password))
            $userDTO->password = $user->password;

        $user->fill($userDTO->toArray());
        $user->update();
        return UserDTO::from($user);
    }

    public function vincularPerfil(array $perfil, int $userId): UserDTO
    {
        $user = User::find($userId);
        $user->syncRoles($perfil);

        return UserDTO::from($user);
    }

    public function salvar(UserDTO $userDTO): UserDTO
    {
        $user = new User($userDTO->toArray());
        $user->save();
        return UserDTO::from($user);
    }

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe): bool
    {
        $user = User::find($idUsuario);
        $user->selected_equipe_id = $idEquipe;
        return $user->save();
    }
}
