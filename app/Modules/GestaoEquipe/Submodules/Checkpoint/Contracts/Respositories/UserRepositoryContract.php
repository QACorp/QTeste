<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories;
use App\System\Contracts\Repository\UserRepositoryContract as BaseUserRepositoryContract;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

interface UserRepositoryContract extends BaseUserRepositoryContract
{
    public function listarUsuariosPaginado(int $idEquipe, int $page = null, int $limit = null): DataCollection|PaginatedDataCollection;
}
