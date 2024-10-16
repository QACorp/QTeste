<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Business;
use App\System\Contracts\Business\UserBusinessContract  as BaseUserBusinessContract;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

interface UserBusinessContract extends BaseUserBusinessContract
{
    public function listarUsuariosPaginado(int $idEquipe, int $page = null, int $limit = null): DataCollection|PaginatedDataCollection;
}
