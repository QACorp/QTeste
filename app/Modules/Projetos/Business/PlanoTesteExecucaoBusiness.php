<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class PlanoTesteExecucaoBusiness extends BusinessAbstract implements PlanoTesteExecucaoBusinessContract
{
    public function __construct(
        private readonly PlanoTesteExecucaoRepositoryContract $planoTesteExecucaoRepository,
        private readonly CasoTesteExecucaoBusinessContract $casoTesteExecucaoBusiness
    )
    {
    }

    public function buscarUltimoPlanoTesteExecucaoPorPlanoTeste(int $idPlanoTeste): ?PlanoTesteExecucaoDTO
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        $planoTesteExecucao =  $this->planoTesteExecucaoRepository->buscarUltimoPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);
        return $planoTesteExecucao;

    }

    public function criarExecucaoTeste(int $idPlanoTeste): PlanoTesteExecucaoDTO
    {
        $this->can(PermissionEnum::INSERIR_EXECUCAO_PLANO_TESTE->value);
        return $this->planoTesteExecucaoRepository->criarExecucaoTeste($idPlanoTeste);
    }

    public function finalizarPlanoTesteExecucao(int $idPlanoTesteExecucao): bool
    {
        $this->can(PermissionEnum::FINALIZAR_PLANO_TESTE->value);
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

    public function buscarTodosPlanoTesteExecucao(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        return $this->planoTesteExecucaoRepository->buscarTodosPlanoTesteExecucao();
    }

    public function buscarPlanoTesteExecucaoPorId(int $idPlanoTesteExecucao): ?PlanoTesteExecucaoDTO
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        $planoTesteExecucao = $this->planoTesteExecucaoRepository->buscarPlanoTesteExecucaoPorId($idPlanoTesteExecucao);
        if(!$planoTesteExecucao)
            throw new NotFoundException();

        return $planoTesteExecucao;
    }

    public function buscarPlanosTesteExecucaoPorPlanoTeste(int $idPlanoTeste): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_EXECUCAO_PLANO_TESTE->value);
        return $this->planoTesteExecucaoRepository->buscarPlanosTesteExecucaoPorPlanoTeste($idPlanoTeste);
    }
}
