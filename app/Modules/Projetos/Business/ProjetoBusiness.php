<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Requests\ProjetosPostRequest;
use App\Modules\Projetos\Requests\ProjetosPutRequest;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class ProjetoBusiness extends BusinessAbstract implements ProjetoBusinessContract
{
    public function __construct(
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness,
        private readonly EquipeBusinessContract $equipeBusiness
    )
    {
    }

    public function buscarTodosPorAplicacao(int $aplicacaoId, int $idEquipe, string $guard = 'web'): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_PROJETO->value, $guard);
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::guard($guard)->user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        try {
            $this->aplicacaoBusiness->buscarPorId($aplicacaoId, $idEquipe, $guard);
            return $this->projetoRepository->buscarTodosPorAplicacao($aplicacaoId, $idEquipe);
        }catch (NotFoundException $exception){
            throw $exception;
        }

    }

    public function buscarPorAplicacaoEProjeto(int $idAplicacao, int $idProjeto, int $idEquipe): ProjetoDTO
    {
        $this->can(PermissionEnum::LISTAR_PROJETO->value);
        $projeto = $this->projetoRepository->buscarPorId($idProjeto, $idEquipe);

        if($projeto == null || $projeto->aplicacao_id != $idAplicacao)
            throw new NotFoundException();

        return $projeto;
    }

    public function atualizar(ProjetoDTO $projetoDTO, ProjetosPutRequest $projetosPutRequest = new ProjetosPutRequest()): ProjetoDTO
    {
        $this->can(PermissionEnum::ALTERAR_PROJETO->value);

        $validator = Validator::make($projetoDTO->toArray(), $projetosPutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->projetoRepository->atualizar($projetoDTO);
    }

    public function excluir(int $idAplicacao, int $idProjeto): bool
    {
        $this->can(PermissionEnum::REMOVER_PROJETO->value);
        if(!$this->projetoExists($idAplicacao, $idProjeto))
            throw new NotFoundException();

        return $this->projetoRepository->excluir($idProjeto);
    }

    public function projetoExists(int $idAplicacao, int $idProjeto, int $idEquipe):bool
    {
        $projeto = $this->projetoRepository->buscarPorId($idProjeto, $idEquipe);
        if($projeto == null || $projeto->aplicacao_id != $idAplicacao){
            return false;
        }
        return true;
    }

    public function inserir(ProjetoDTO $projetoDTO, ProjetosPostRequest $projetosPostRequest = new ProjetosPostRequest()): ProjetoDTO
    {
        //$this->can(PermisissionEnum::INSERIR_PROJETO->value);
        $validator = Validator::make($projetoDTO->toArray(), $projetosPostRequest->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->projetoRepository->inserir($projetoDTO);
    }

    public function buscarPorIdProjeto(int $idProjeto, int $idEquipe, string $guard = 'web'): ?ProjetoDTO
    {
        $this->can(PermissionEnum::LISTAR_PROJETO->value, $guard);
        $projeto = $this->projetoRepository->buscarPorId($idProjeto, $idEquipe);
        if($projeto == null)
            throw new NotFoundException();

        return $projeto;
    }

    public function buscarTodosPorEquipe(int $idEquipe, string $guard = 'web'): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_PROJETO->value, $guard);
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::guard($guard)->user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        return $this->projetoRepository->buscarTodosPorEquipe($idEquipe);
    }
}
