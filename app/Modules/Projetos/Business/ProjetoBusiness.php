<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Requests\AplicacoesPutRequest;
use App\Modules\Projetos\Requests\ProjetosPostRequest;
use App\Modules\Projetos\Requests\ProjetosPutRequest;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class ProjetoBusiness implements ProjetoBusinessContract
{
    public function __construct(
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
    }

    public function buscarTodosPorAplicacao(int $aplicacaoId): DataCollection
    {
        try {
            $this->aplicacaoBusiness->buscarPorId($aplicacaoId);
            return $this->projetoRepository->buscarTodosPorAplicacao($aplicacaoId);
        }catch (NotFoundException $exception){
            throw $exception;
        }

    }

    public function buscarPorAplicacaoEProjeto(int $idAplicacao, int $idProjeto): ProjetoDTO
    {
        $projeto = $this->projetoRepository->buscarPorId($idProjeto);

        if($projeto == null || $projeto->aplicacao_id != $idAplicacao)
            throw new NotFoundException();

        return $projeto;
    }

    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO
    {
        if(!$this->projetoExists($projetoDTO->aplicacao_id, $projetoDTO->id))
            throw new NotFoundException();

        $validator = Validator::make($projetoDTO->toArray(), (new ProjetosPutRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->projetoRepository->atualizar($projetoDTO);
    }

    public function excluir(int $idAplicacao, int $idProjeto): bool
    {
        if(!$this->projetoExists($idAplicacao, $idProjeto))
            throw new NotFoundException();

        return $this->projetoRepository->excluir($idProjeto);
    }

    public function projetoExists(int $idAplicacao, int $idProjeto):bool
    {
        $projeto = $this->projetoRepository->buscarPorId($idProjeto);
        if($projeto == null || $projeto->aplicacao_id != $idAplicacao){
            return false;
        }
        return true;
    }

    public function inserir(ProjetoDTO $projetoDTO): ProjetoDTO
    {
        $validator = Validator::make($projetoDTO->toArray(), (new ProjetosPostRequest())->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->projetoRepository->inserir($projetoDTO);
    }

    public function buscarPorIdProjeto(int $idProjeto): ?ProjetoDTO
    {
        return $this->projetoRepository->buscarPorId($idProjeto);
    }
}
