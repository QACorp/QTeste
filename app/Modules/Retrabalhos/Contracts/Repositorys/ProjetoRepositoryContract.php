<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Retrabalhos\DTOs\ProjetoDTO;
use Spatie\LaravelData\DataCollection;
use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract as BaseRepositoryContract;

interface ProjetoRepositoryContract extends BaseRepositoryContract
{
    public function buscarPorIdProjeto(int $idProjeto, int $idEquipe): ?ProjetoDTO;
}
