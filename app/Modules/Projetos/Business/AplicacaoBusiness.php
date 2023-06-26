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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class AplicacaoBusiness extends BusinessAbstract implements AplicacaoBusinessContract
{
    use Authverification;
    public function __construct(
        private readonly AplicacaoRepositoryContract $aplicacaoRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_APLICACAO->value);
        if(!$this->userMembroEquipe(Cookie::get('equipe'))){
           throw new UnauthorizedException(403);
        }
        return  $this->aplicacaoRepository->buscarTodos(Cookie::get('equipe'));
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO, AplicacoesPostRequest $aplicacoesPostRequest = new AplicacoesPostRequest()): AplicacaoDTO
    {
        $this->can(PermissionEnum::INSERIR_APLICACAO->value);
        $validator = Validator::make($aplicacaoDTO->toArray(), $aplicacoesPostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->aplicacaoRepository->salvar($aplicacaoDTO);
    }

    public function buscarPorId(int $id): AplicacaoDTO
    {
        $this->can(PermissionEnum::LISTAR_APLICACAO->value);
        return $this->aplicacaoRepository->buscarPorId($id) ?? throw new NotFoundException();
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO, AplicacoesPutRequest $aplicacoesPutRequest = new AplicacoesPutRequest()): AplicacaoDTO
    {
        $this->can(PermissionEnum::ALTERAR_APLICACAO->value);
        if($this->buscarPorId($aplicacaoDTO->id) == null){
            throw new NotFoundException();
        }

        $validator = Validator::make($aplicacaoDTO->toArray(), $aplicacoesPutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->aplicacaoRepository->alterar($aplicacaoDTO);
    }

    public function excluir(int $id): bool
    {
        $this->can(PermissionEnum::REMOVER_APLICACAO->value);
        if($this->buscarPorId($id) == null){
            throw new NotFoundException();
        }
        return $this->aplicacaoRepository->excluir($id);
    }
}
