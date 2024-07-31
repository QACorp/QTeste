<?php

namespace App\Modules\GestaoEquipe\Contracts\Repositorys;

use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use Spatie\LaravelData\DataCollection;

interface AlocacaoRepositoryContract
{
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO;
    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO;
    public function excluirAlocacao(int $id): bool;
    public function consultarAlocacao(int $id): DataCollection;
    public function listarAlocacoes(int $idEquipe): DataCollection;
    public function listarAlocacoesPorUsuario(int $idUsuario, int $idEmpresa): DataCollection;
}
