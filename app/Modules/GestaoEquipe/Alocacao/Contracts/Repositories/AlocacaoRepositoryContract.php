<?php

namespace App\Modules\GestaoEquipe\Alocacao\Contracts\Repositories;

use App\Modules\GestaoEquipe\Alocacao\DTOs\AlocacaoDTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;

interface AlocacaoRepositoryContract
{
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO;
    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO;
    public function excluirAlocacao(int $id): bool;
    public function consultarAlocacao(int $id, int $idEquipe): ?AlocacaoDTO;
    public function listarAlocacoes(int $idEquipe): DataCollection;
    public function listarAlocacoesPorUsuario(int $idEquipe, int $idUsuario): DataCollection;
    public function hasAlocacaoInDate(int $userId, int $equipeId, string $inicio, string $termino, int $alocacaoId = null): bool;
    public function usuariosDisponiveis(int $idEquipe, Carbon $inicio, Carbon $termino): DataCollection;
    public function listarAlocacoesPorData(int $idEquipe, int $idUsuario, Carbon $data): DataCollection;
}
