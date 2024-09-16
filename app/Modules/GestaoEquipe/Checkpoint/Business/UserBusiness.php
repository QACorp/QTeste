<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Business;


use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\UserRepositoryContract;
use App\System\Business\UserBusiness as BaseUserBusiness;
use App\System\Contracts\Business\EquipeBusinessContract;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class UserBusiness extends  BaseUserBusiness implements UserBusinessContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    )
    {
        parent::__construct($userRepository, App::make(EquipeBusinessContract::class));
    }

    public function listarUsuariosPaginado(int $idEquipe, int $page = null, int $limit = null): DataCollection|PaginatedDataCollection
    {
        return $this->userRepository->listarUsuariosPaginado($idEquipe, $page, $limit);
    }
}
