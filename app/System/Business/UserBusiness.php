<?php

namespace App\System\Business;


use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\DTOs\UserDTO;
use App\System\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\PasswordPutRequest;
use App\System\Requests\UserPostRequest;
use App\System\Requests\UserPutRequest;
use App\System\Traits\EquipeTools;
use App\System\Traits\Validation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class UserBusiness extends BusinessAbstract implements UserBusinessContract
{
    use Validation;
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarTodos();
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $this->can(PermissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarPorId($userId);
    }

    public function alterar(UserDTO $userDTO, UserPutRequest $userPutRequest = new UserPutRequest()): UserDTO
    {
        $this->can(PermissionEnum::ALTERAR_USUARIO->value);
        if($this->buscarPorId($userDTO->id) == null){
            throw new NotFoundException();
        }

        $this->validation($userDTO->toArray(), $userPutRequest);
        $user = $this->userRepository->alterar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function salvar(UserDTO $userDTO, UserPostRequest $userPostRequest = new UserPostRequest()): UserDTO
    {
        $this->can(PermissionEnum::INSERIR_USUARIO->value);

        $this->validation($userDTO->toArray(), $userPostRequest);
        $user = $this->userRepository->salvar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function alterarSenha(UserDTO $userDTO, PasswordPutRequest $passwordPutRequest = new PasswordPutRequest()): UserDTO
    {
        $this->can(PermissionEnum::ALTERAR_SENHA_USUARIO->value);
        $user = $this->buscarPorId($userDTO->id);
        if($user == null){
            throw new NotFoundException();
        }
        $this->validation($userDTO->toArray(), $passwordPutRequest);
        $userDTO = UserDTO::from([...$user->except('password')->toArray(), 'password' => Hash::make($userDTO->password)]);
        $user = $this->userRepository->alterar($userDTO);
        return $user;
    }

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe): bool
    {

        return $this->userRepository->alterarEquipeSelecionada($idUsuario, $idEquipe);
    }
}
