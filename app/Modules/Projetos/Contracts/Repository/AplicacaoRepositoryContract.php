<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use Spatie\LaravelData\DataCollection;

interface AplicacaoRepositoryContract
{
    public function buscarTodos(int $idEquipe):DataCollection;
    public function buscarPorId(int $id, int $idEquipe):?AplicacaoDTO;
    public function salvar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;

    public function alterar(AplicacaoDTO $aplicacaoDTO):AplicacaoDTO;

    public function excluir(int $id): bool;
}
