<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use App\Modules\Projetos\Models\CasoTesteExecucao;
use App\System\Exceptions\ConflictException;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoBusiness implements CasoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly CasoTesteExecucaoRepositoryContract $casoTesteExecucaoRepository
    )
    {
    }


    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status): bool
    {
        if($this->casoTesteExecucaoRepository->buscarCasoTesteExecucao($idPlanoTesteExecucao, $idCasoTeste))
            throw new ConflictException();
        return $this->casoTesteExecucaoRepository->executarCasoTeste($idPlanoTesteExecucao, $idCasoTeste, $status);
    }

    public function casoTesteExecutado(int $idPlanoTesteExecucao, int $idCasoTeste): ?CasoTesteExecucaoDTO
    {
        return $this->casoTesteExecucaoRepository->buscarCasoTesteExecucao($idPlanoTesteExecucao, $idCasoTeste);

    }

    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao): DataCollection
    {
        return  $this->casoTesteExecucaoRepository->buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao($idPlanoTesteExecucao);
    }
}
