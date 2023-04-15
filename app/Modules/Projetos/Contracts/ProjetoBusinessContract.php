<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface ProjetoBusinessContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId):DataCollection;
}
