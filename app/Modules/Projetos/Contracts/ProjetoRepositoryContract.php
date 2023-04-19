<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use Spatie\LaravelData\DataCollection;

interface ProjetoRepositoryContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId):DataCollection;
    public function buscarPorId(int $idProjeto): ?ProjetoDTO;
    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO;
    public function excluir(int $id): bool;
    public function inserir(ProjetoDTO $projetoDTO): ProjetoDTO;
}
