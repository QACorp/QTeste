<?php

namespace App\System\Business;

use App\System\Contracts\UserBusinessContract;
use App\System\Contracts\UserRepositoryContract;
use App\System\DTOs\UserDTO;
use App\System\Enuns\PermisissionEnum;
use App\System\Impl\BusinessAbstract;
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
}
