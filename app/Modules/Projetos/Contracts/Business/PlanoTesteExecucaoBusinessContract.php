<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoBusinessContract
{
    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?PlanoTesteExecucaoDTO;
    public function criarExecucaoTeste(int $idPlanoTeste, int $idEquipe):PlanoTesteExecucaoDTO;
    public function buscarTodosPlanoTesteExecucao(int $idEquipe):DataCollection;
    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao, int $idEquipe):bool;
    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao, int $idEquipe):?PlanoTesteExecucaoDTO;
    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste, int $idEquipe): DataCollection;
}
