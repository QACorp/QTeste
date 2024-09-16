<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Repository\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\AplicacoesPutRequest;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Traits\Authverification;
use App\System\Traits\Validation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class AplicacaoBusiness extends BusinessAbstract implements AplicacaoBusinessContract
{
    use Authverification, Validation;
    public function __construct(
        private readonly AplicacaoRepositoryContract $aplicacaoRepository
    )
    {
    }

    public function buscarTodos(int $idEquipe, string $guard = 'web'): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_APLICACAO->value, $guard);
        if(!$this->userMembroEquipe($idEquipe, $guard)){
           throw new UnauthorizedException(403);
        }
        return  $this->aplicacaoRepository->buscarTodos($idEquipe);
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO, AplicacoesPostRequest $aplicacoesPostRequest = new AplicacoesPostRequest()): AplicacaoDTO
    {
        $this->can(PermissionEnum::INSERIR_APLICACAO->value);
        $this->validation($aplicacaoDTO->toArray(), $aplicacoesPostRequest);

        return $this->aplicacaoRepository->salvar($aplicacaoDTO);
    }

    public function buscarPorId(int $id, int $idEquipe, string $guard = 'web'): AplicacaoDTO
    {
        $this->can(PermissionEnum::LISTAR_APLICACAO->value, $guard);
        if(!$this->userMembroEquipe($idEquipe, $guard)){
            throw new UnauthorizedException(403);
        }
        return $this->aplicacaoRepository->buscarPorId($id, $idEquipe) ?? throw new NotFoundException();
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO, int $equipeId, AplicacoesPutRequest $aplicacoesPutRequest = new AplicacoesPutRequest()): AplicacaoDTO
    {
        $this->can(PermissionEnum::ALTERAR_APLICACAO->value);
        if($this->buscarPorId($aplicacaoDTO->id, $equipeId) == null || !$this->userMembroEquipe($equipeId)){
            throw new NotFoundException();
        }

        $this->validation($aplicacaoDTO->toArray(), $aplicacoesPutRequest);

        return $this->aplicacaoRepository->alterar($aplicacaoDTO);
    }

    public function excluir(int $id, int $equipeId): bool
    {
        $this->can(PermissionEnum::REMOVER_APLICACAO->value);
        if($this->buscarPorId($id, $equipeId) == null || !$this->userMembroEquipe($equipeId)){
            throw new NotFoundException();
        }
        return $this->aplicacaoRepository->excluir($id);
    }
}
