<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface ObservacaoRepositoryContract extends BaseRepositoryContract
{
    public function buscarPorProjeto(int $projetoId): DataCollection;
    public function salvar(ObservacaoDTO $observacaoDTO): ObservacaoDTO;
}
