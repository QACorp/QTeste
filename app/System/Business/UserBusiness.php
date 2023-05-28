<?php

namespace App\System\Business;

use App\System\Contracts\UserBusinessContract;
use App\System\Contracts\UserRepositoryContract;
use App\System\DTOs\UserDTO;
use App\System\Enuns\PermisissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\PasswordPutRequest;
use App\System\Requests\UserPostRequest;
use App\System\Requests\UserPutRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class UserBusiness extends BusinessAbstract implements UserBusinessContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarTodos();
    }

    public function buscarPorId(int $userId): ?UserDTO
    {
        $this->can(PermisissionEnum::LISTAR_USUARIO->value);
        return $this->userRepository->buscarPorId($userId);
    }

    public function alterar(UserDTO $userDTO, UserPutRequest $userPutRequest = new UserPutRequest()): UserDTO
    {
        $this->can(PermisissionEnum::ALTERAR_USUARIO->value);
        if($this->buscarPorId($userDTO->id) == null){
            throw new NotFoundException();
        }
        $validator = Validator::make($userDTO->toArray(), $userPutRequest->rules($userDTO->id));
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        $user = $this->userRepository->alterar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function salvar(UserDTO $userDTO, UserPostRequest $userPostRequest = new UserPostRequest()): UserDTO
    {
        $this->can(PermisissionEnum::INSERIR_USUARIO->value);
        $validator = Validator::make($userDTO->toArray(), $userPostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        $user = $this->userRepository->salvar($userDTO);
        $this->userRepository->vincularPerfil($userDTO->roles->toArray(), $user->id);
        return $user;
    }

    public function alterarSenha(UserDTO $userDTO, PasswordPutRequest $passwordPutRequest = new PasswordPutRequest()): UserDTO
    {
        $this->can(PermisissionEnum::ALTERAR_SENHA_USUARIO->value);
        $user = $this->buscarPorId($userDTO->id);
        if($user == null){
            throw new NotFoundException();
        }

        $validator = Validator::make($userDTO->toArray(), $passwordPutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        $userDTO = UserDTO::from([...$user->except('password')->toArray(), 'password' => Hash::make($userDTO->password)]);
        $user = $this->userRepository->alterar($userDTO);
        return $user;
    }
}
