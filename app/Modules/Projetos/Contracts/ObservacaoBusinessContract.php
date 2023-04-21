<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\ObservacaoDTO;
use Spatie\LaravelData\DataCollection;

interface ObservacaoBusinessContract
{
    public function buscarPorProjeto(int $projetoId): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO): ObservacaoDTO;
}
