<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface ProjetoRepositoryContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId):DataCollection;
}
