<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoRepositoryContract
{
    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO;
    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste): DataCollection;
    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao):?PlanoTesteExecucaoDTO;
    public function buscarTodosPlanoTesteExecucao():DataCollection;
    public function criarExecucaoTeste(int $idPlanoTeste):PlanoTesteExecucaoDTO;
    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, string $resultado):bool;
}
