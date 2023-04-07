<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use Spatie\LaravelData\DataCollection;

interface AplicacaoRepositoryContract
{
    public function buscarTodos():DataCollection;
    public function salvar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;
}
