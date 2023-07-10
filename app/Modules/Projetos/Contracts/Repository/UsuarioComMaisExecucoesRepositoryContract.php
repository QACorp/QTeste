<?php

namespace App\Modules\Projetos\Contracts\Repository;

use Spatie\LaravelData\DataCollection;

interface UsuarioComMaisExecucoesRepositoryContract
{
    public function buscarUsuarioPorOrdemExecucao(int $limit, int $idEquipe): DataCollection;
}
