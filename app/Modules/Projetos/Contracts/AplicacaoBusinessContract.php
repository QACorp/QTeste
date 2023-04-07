<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

interface AplicacaoBusinessContract
{
    public function buscarTodos():DataCollection;
    public function salvar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;
}
