<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use App\System\Enuns\PermisissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class CasoTesteBusiness extends BusinessAbstract implements CasoTesteBusinessContract
{
    public function __construct(
        private readonly CasoTesteRespositoryContract $casoTesteRespository
    )
    {
    }

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorPlanoTeste($idPlanoTeste);
    }

    public function buscarCasoTestePorString(string $term): ?DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorString($term);
    }

    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {
        $this->can(PermisissionEnum::VINCULAR_CASO_TESTE->value);
        if($this->casoTesteRespository->existeVinculo($idPlanoTeste, $casoTesteDTO->id)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->vincular($idPlanoTeste, $casoTesteDTO);
    }

    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePostRequest $casoTestePostRequest = new CasoTestePostRequest()): CasoTesteDTO
    {
        $this->can(PermisissionEnum::INSERIR_CASO_TESTE->value);
        $validator = Validator::make($casoTesteDTO->toArray(), $casoTestePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO);
    }

    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO
    {
        $this->can(PermisissionEnum::DESVINCULAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeVinculo($idPlanoTeste, $idCasoTeste)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->desvincular($idPlanoTeste, $idCasoTeste);
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarTodos();
    }

    public function excluir(int $idCasoTeste): bool
    {
        $this->can(PermisissionEnum::REMOVER_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->excluir($idCasoTeste);
    }

    public function buscarCasoTestePorId(int $idCasoTeste): ?CasoTesteDTO
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        $casoTeste = $this->casoTesteRespository->buscarCasoTestePorId($idCasoTeste);
        if($casoTeste == null)
            throw new NotFoundException();

        return $casoTeste;
    }

    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePutRequest $casoTestePutRequest = new CasoTestePutRequest()): CasoTesteDTO
    {
        $this->can(PermisissionEnum::ALTERAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id))
            throw new NotFoundException();

        $validator = Validator::make($casoTesteDTO->toArray(), $casoTestePutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->casoTesteRespository->alterarCasoTeste($casoTesteDTO);
    }
}
