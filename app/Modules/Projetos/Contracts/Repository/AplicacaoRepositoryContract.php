<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface AplicacaoRepositoryContract extends BaseRepositoryContract
{
    public function buscarTodos(int $idEquipe):DataCollection;
    public function buscarPorId(int $id, int $idEquipe):?AplicacaoDTO;
    public function salvar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;

    public function alterar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;

    public function excluir(int $id): bool;
}
