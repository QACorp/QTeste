<?php

namespace App\Modules\Projetos\Contracts\Business;

use Spatie\LaravelData\DataCollection;

interface UsuarioComMaisExecucoesBusinessContract
{
    public function buscarUsuarioPorOrdemExecucao(int $limit): DataCollection;
}
