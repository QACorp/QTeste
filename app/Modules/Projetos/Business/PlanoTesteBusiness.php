<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\PlanoTestePostRequest;
use App\Modules\Projetos\Requests\PlanoTestePutRequest;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class PlanoTesteBusiness extends BusinessAbstract implements PlanoTesteBusinessContract
{
    public function __construct(
        private readonly PlanoTesteRepositoryContract $planoTesteRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarPlanosTestePorProjeto(int $idProjeto): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_PLANO_TESTE->value);
        return $this->planoTesteRepository->buscarPlanosTestePorProjeto($idProjeto);
    }

    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO, PlanoTestePostRequest $planoTestePostRequest = new PlanoTestePostRequest()): PlanoTesteDTO
    {
        $this->can(PermissionEnum::INSERIR_PLANO_TESTE->value);
        if($this->projetoBusiness->buscarPorIdProjeto($planoTesteDTO->projeto_id) == null)
            throw new NotFoundException();

        $validator = Validator::make($planoTesteDTO->toArray(), $planoTestePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->planoTesteRepository->salvarPlanoTeste($planoTesteDTO);
    }

    public function excluirPlanoTeste(int $idPlanoTeste): bool
    {
        $this->can(PermissionEnum::REMOVER_PLANO_TESTE->value);
        if($this->planoTesteRepository->buscarPlanoTestePorId($idPlanoTeste) == null)
            throw new NotFoundException();
        return $this->planoTesteRepository->excluirPlanoTeste($idPlanoTeste);
    }

    public function buscarPlanoTestePorId(int $idPlanoTeste): ?PlanoTesteDTO
    {
        $this->can(PermissionEnum::LISTAR_PLANO_TESTE->value);
        $planoTeste = $this->planoTesteRepository->buscarPlanoTestePorId($idPlanoTeste);
        if(!$planoTeste)
            throw new NotFoundException();
        return $planoTeste;
    }

    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO, PlanoTestePutRequest $planoTestePutRequest = new PlanoTestePutRequest()): PlanoTesteDTO
    {
        $this->can(PermissionEnum::ALTERAR_PLANO_TESTE->value);
        if($this->buscarPlanoTestePorId($planoTesteDTO->id) == null)
            throw new NotFoundException();

        $validator = Validator::make($planoTesteDTO->toArray(), $planoTestePutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->planoTesteRepository->alterarPlanoTeste($planoTesteDTO);
    }

    public function buscarTodosPlanoTeste(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_PLANO_TESTE->value);
        return $this->planoTesteRepository->buscarTodosPlanoTeste();
    }
}
