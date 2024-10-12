<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories;

use Spatie\LaravelData\DataCollection;
use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract as BaseProjetoRepositoryContract;

interface ProjetoRepositoryContract extends BaseProjetoRepositoryContract
{
    public function getProjetos(int $idEquipe): DataCollection;
}
