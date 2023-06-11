<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface UsuarioComMaisExecucoesBusinessContract
{
    public function buscarUsuarioPorOrdemExecucao(int $limit): DataCollection;
}
