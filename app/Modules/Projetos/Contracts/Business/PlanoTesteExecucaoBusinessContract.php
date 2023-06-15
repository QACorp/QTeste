<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoBusinessContract
{
    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO;
    public function criarExecucaoTeste(int $idPlanoTeste):PlanoTesteExecucaoDTO;
    public function buscarTodosPlanoTesteExecucao():DataCollection;
    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao):bool;
    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao):?PlanoTesteExecucaoDTO;
    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste): DataCollection;
}
