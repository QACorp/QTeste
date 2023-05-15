<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoRepositoryContract
{
    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO;
    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao):?PlanoTesteExecucaoDTO;
    public function criarExecucaoTeste(int $idPlanoTeste):PlanoTesteExecucaoDTO;
    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, string $resultado):bool;
}
