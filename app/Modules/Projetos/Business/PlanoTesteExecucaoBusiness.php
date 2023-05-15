<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum;
use App\System\Exceptions\NotFoundException;
use http\Client\Curl\User;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoBusiness implements PlanoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly PlanoTesteExecucaoRepositoryContract $planoTesteExecucaoRepository,
        private readonly CasoTesteExecucaoBusinessContract $casoTesteExecucaoBusiness
    )
    {
    }

    public function buscarPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO
    {
        return  $this->planoTesteExecucaoRepository->buscarUltimoPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);

    }

    public function criarExecucaoTeste(int $idPlanoTeste): PlanoTesteExecucaoDTO
    {
        return $this->planoTesteExecucaoRepository->criarExecucaoTeste($idPlanoTeste);
    }

    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao): bool
    {
        if(!$this->planoTesteExecucaoRepository->buscarPlanoTesteExecucaoPorId($idPlanoTesteExecucao))
            throw new NotFoundException();

        $casosTeste = $this->casoTesteExecucaoBusiness->buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao($idPlanoTesteExecucao);
        $status = PlanoTesteExecucaoEnum::PASSOU->value;
        if($casosTeste->count() == 0){
            $status = PlanoTesteExecucaoEnum::ABANDONADO->value;
        }

        $casosTeste->each(function($item, $key) use(&$status){

            if($item->resultado == PlanoTesteExecucaoEnum::FALHOU->value){
                $status = PlanoTesteExecucaoEnum::FALHOU->value;
            }
        });
        return $this->planoTesteExecucaoRepository->finalizarPlanoTesteExecucao($idPlanoTesteExecucao, $status);

    }
}
