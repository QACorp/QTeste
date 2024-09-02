<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Business;


use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\UserRepositoryContract;
use App\System\Business\UserBusiness as BaseUserBusiness;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class UserBusiness extends  BaseUserBusiness implements UserBusinessContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    )
    {
    }

    public function listarUsuariosPaginado(int $idEquipe, int $page = null, int $limit = null): DataCollection|PaginatedDataCollection
    {
        return $this->userRepository->listarUsuariosPaginado($idEquipe, $page, $limit);
    }
}
