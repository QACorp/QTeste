<?php

namespace App\Modules\GestaoEquipe\Contracts\Business;

use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use Spatie\LaravelData\DataCollection;

interface AlocacaoBusinessContract
{
//Criar métodos para criar, alterar, excluir e consultar alocacoes
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO;
    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO;
    public function excluirAlocacao(int $id): bool;
    public function consultarAlocacao(int $id): DataCollection;
    public function listarAlocacoes(int $idEquipe): DataCollection;

}
