<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\ObservacaoDTO;
use Spatie\LaravelData\DataCollection;

interface ObservacaoRepositoryContract
{
    public function buscarPorProjeto(int $projetoId): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO): ObservacaoDTO;
}
