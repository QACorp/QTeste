<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoRepositoryContract extends BaseRepositoryContract
{
    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?PlanoTesteExecucaoDTO;
    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe): DataCollection;
    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao, int $idEquipe):?PlanoTesteExecucaoDTO;
    public function buscarTodosPlanoTesteExecucao(int $idEquipe):DataCollection;
    public function criarExecucaoTeste(int $idPlanoTeste, int $idEquipe):PlanoTesteExecucaoDTO;
    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, string $resultado, int $idEquipe):bool;
}
