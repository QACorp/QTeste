<?php

namespace App\System\Contracts;

use App\System\DTOs\UserDTO;
use App\System\Requests\UserPostRequest;
use App\System\Requests\UserPutRequest;
use Spatie\LaravelData\DataCollection;

interface UserBusinessContract
{
    public function buscarTodos():DataCollection;
    public function buscarPorId(int $userId): ?UserDTO;
    public function alterar(UserDTO $userDTO, UserPutRequest $userPutRequest = new UserPutRequest()): UserDTO;
    public function salvar(UserDTO $userDTO, UserPostRequest $userPostRequest = new UserPostRequest()): UserDTO;
}
