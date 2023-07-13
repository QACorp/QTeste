<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface UsuarioComMaisExecucoesRepositoryContract extends BaseRepositoryContract
{
    public function buscarUsuarioPorOrdemExecucao(int $limit, int $idEquipe): DataCollection;
}
