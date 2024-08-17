<?php

namespace App\Modules\GestaoEquipe\Contracts\Business;

use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;

interface AlocacaoBusinessContract
{
//Criar métodos para criar, alterar, excluir e consultar alocacoes
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO;
    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO;

    public function excluirAlocacao(int $id): bool;
    public function consultarAlocacao(int $id, int $idEquipe): ?AlocacaoDTO;
    public function listarAlocacoes(int $idEquipe): DataCollection;
    public function usuariosDisponiveis(int $idEquipe, Carbon $inicio, Carbon $termino): DataCollection;
    public function buscarProjetosVigentes(int $equipeId, Carbon $dataInicio, Carbon $dataFim): DataCollection;
    public function marcarAlocacaoComoConcluida(int $idAlocacao, int $idEquipe): AlocacaoDTO;
    public function listarMinhasAlocacoes(int $idEquipe, int $idUsuario): DataCollection;


}
