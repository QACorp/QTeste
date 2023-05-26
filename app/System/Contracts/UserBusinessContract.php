<?php

namespace App\System\Contracts;

use App\System\DTOs\UserDTO;
use Spatie\LaravelData\DataCollection;

interface UserBusinessContract
{
    public function buscarTodos():DataCollection;
    public function buscarPorId(int $userId): ?UserDTO;
    public function alterar(UserDTO $userDTO): UserDTO;
}
