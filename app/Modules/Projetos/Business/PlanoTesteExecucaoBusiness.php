<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoBusiness implements PlanoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly PlanoTesteExecucaoRepositoryContract $planoTesteExecucaoRepository
    )
    {
    }

    public function buscarPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO
    {
        return  $this->planoTesteExecucaoRepository->buscarPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);

    }

    public function criarExecucaoTeste(int $idPlanoTeste): PlanoTesteExecucaoDTO
    {
        return $this->planoTesteExecucaoRepository->criarExecucaoTeste($idPlanoTeste);
    }
}
