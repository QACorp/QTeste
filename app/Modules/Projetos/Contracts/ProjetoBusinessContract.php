<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use Spatie\LaravelData\DataCollection;

interface ProjetoBusinessContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId):DataCollection;
    public function buscarPorAplicacaoEProjeto(int $idAplicacao, int $idProjeto):ProjetoDTO;
    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO;
    public function excluir(int $idAplicacao, int $idProjeto): bool;
    public function inserir(ProjetoDTO $projetoDTO): ProjetoDTO;
}
