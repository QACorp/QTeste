<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\AplicacoesPutRequest;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class AplicacaoBusiness implements AplicacaoBusinessContract
{
    public function __construct(
        private readonly AplicacaoRepositoryContract $aplicacaoRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        return  $this->aplicacaoRepository->buscarTodos();
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {

        $validator = Validator::make($aplicacaoDTO->toArray(), (new AplicacoesPostRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->aplicacaoRepository->salvar($aplicacaoDTO);
    }

    public function buscarPorId(int $id): AplicacaoDTO
    {
        return $this->aplicacaoRepository->buscarPorId($id) ?? throw new NotFoundException();
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        if($this->buscarPorId($aplicacaoDTO->id) == null){
            throw new NotFoundException();
        }

        $validator = Validator::make($aplicacaoDTO->toArray(), (new AplicacoesPutRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->aplicacaoRepository->alterar($aplicacaoDTO);
    }

    public function excluir(int $id): bool
    {
        if($this->buscarPorId($id) == null){
            throw new NotFoundException();
        }
        return $this->aplicacaoRepository->excluir($id);
    }
}
