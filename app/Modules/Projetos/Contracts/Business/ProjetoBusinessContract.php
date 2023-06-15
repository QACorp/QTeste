<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Requests\ProjetosPostRequest;
use App\Modules\Projetos\Requests\ProjetosPutRequest;
use Spatie\LaravelData\DataCollection;

interface ProjetoBusinessContract
{
    public function buscarTodosPorAplicacao(int $aplicacaoId):DataCollection;
    public function buscarPorAplicacaoEProjeto(int $idAplicacao, int $idProjeto):ProjetoDTO;
    public function buscarPorIdProjeto(int $idProjeto):?ProjetoDTO;
    public function atualizar(ProjetoDTO $projetoDTO, ProjetosPutRequest $projetosPutRequest = new ProjetosPutRequest()): ProjetoDTO;
    public function excluir(int $idAplicacao, int $idProjeto): bool;
    public function inserir(ProjetoDTO $projetoDTO, ProjetosPostRequest $projetosPostRequest = new ProjetosPostRequest()): ProjetoDTO;
    public function projetoExists(int $idAplicacao, int $idProjeto):bool;
}
