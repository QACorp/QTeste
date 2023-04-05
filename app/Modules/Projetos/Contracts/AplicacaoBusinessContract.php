<?php

namespace App\Modules\Projetos\Contracts;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

interface AplicacaoBusinessContract
{
    public function buscarTodos():DataCollection;
}
