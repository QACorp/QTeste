<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\DataCollection;

interface AplicacaoRepositoryContract
{
    public function buscarTodos():DataCollection;
}
