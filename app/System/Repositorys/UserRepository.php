<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Impl\BaseRepository;
use App\System\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class UserRepository extends BaseRepository implements UserRepositoryContract
{

    public function buscarTodos(): DataCollection
    {
        return UserDTO::collection(
            User::with('roles')
                ->where('empresa_id', Auth::user()->empresa_id)
                ->get()
        );
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $user = User::where('id', $userId)
                    ->where('empresa_id', Auth::user()->empresa_id)
                    ->with('roles')
                    ->first();

        if($user != null){
            $userDTO = UserDTO::from($user);
            $userDTO->equipes = EquipeDTO::collection($user->equipes);
            return $userDTO;
        }
        return null;
    }

    public function alterar(UserDTO $userDTO): UserDTO
    {

        $user = User::where('empresa_id', Auth::user()->empresa_id)
            ->where('id',$userDTO->id)
            ->first();
        if(empty($userDTO->password))
            $userDTO->password = $user->password;
        try {
            DB::beginTransaction();
            $user->fill($userDTO->except('empresa_id')->toArray());
            $user->update();
            $user = $this->atualizarUsuarioEquipe($userDTO, $user);
            DB::commit();
            return UserDTO::from($user);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function vincularPerfil(array $perfil, int $userId): UserDTO
    {
        $user = User::find($userId);
        $user->syncRoles($perfil);

        return UserDTO::from($user);
    }

    public function salvar(UserDTO $userDTO): UserDTO
    {
        try {
            DB::beginTransaction();
            $user = new User($userDTO->toArray());
            $user->save();
            $user = $this->atualizarUsuarioEquipe($userDTO, $user);
            DB::commit();
            return UserDTO::from($user);
        }catch (Exception $exception){

            DB::rollBack();
            throw $exception;
        }
    }

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe): bool
    {
        $user = User::find($idUsuario);
        $user->selected_equipe_id = $idEquipe;
        return $user->save();
    }
    private function atualizarUsuarioEquipe(UserDTO $userDTO, User $user):User
    {
        $userDTO->equipes->each(function ($item, $key) use ($user, &$idsEquipe) {
            $idsEquipe[] = $item->id;
        });
        $user->equipes()->sync($idsEquipe);
        return $user;
    }

    public function buscarUsuario(array $filter): DataCollection
    {
        $queryBuider = User::query();
        foreach ($filter as $field => $value){
            $queryBuider->where($field, $value);
        }
        $queryBuider->where('empresa_id', Auth::user()->empresa_id);
        return UserDTO::collection($queryBuider->get());
    }

    public function buscarUsuariosPorEquipe(int $idEquipe): DataCollection
    {
        return UserDTO::collection(User::join('users_equipes as ue', 'ue.user_id', '=', 'users.id')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('ue.equipe_id', $idEquipe)
            ->get());
    }
}
