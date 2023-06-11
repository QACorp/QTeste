<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface UsuarioComMaisExecucoesRepositoryContract
{
    public function buscarUsuarioPorOrdemExecucao(int $limit): DataCollection;
}
