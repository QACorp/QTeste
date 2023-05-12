<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteExecucaoRepositoryContract
{
    public function buscarPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO;
    public function criarExecucaoTeste(int $idPlanoTeste):PlanoTesteExecucaoDTO;
}
