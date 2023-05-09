<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class CasoTesteBusiness implements CasoTesteBusinessContract
{
    public function __construct(
        private readonly CasoTesteRespositoryContract $casoTesteRespository
    )
    {
    }

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        return $this->casoTesteRespository->buscarCasoTestePorPlanoTeste($idPlanoTeste);
    }

    public function buscarCasoTestePorString(string $term): ?DataCollection
    {
        return $this->casoTesteRespository->buscarCasoTestePorString($term);
    }

    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {
        if($this->casoTesteRespository->existeVinculo($idPlanoTeste, $casoTesteDTO->id)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->vincular($idPlanoTeste, $casoTesteDTO);
    }

    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO): CasoTesteDTO
    {
        $validator = Validator::make($casoTesteDTO->toArray(), (new CasoTestePostRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO);
    }

    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO
    {
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
        return $this->casoTesteRespository->buscarTodos();
    }

    public function excluir(int $idCasoTeste): bool
    {
        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->excluir($idCasoTeste);
    }

    public function buscarCasoTestePorId(int $idCasoTeste): ?CasoTesteDTO
    {
        $casoTeste = $this->casoTesteRespository->buscarCasoTestePorId($idCasoTeste);
        if($casoTeste == null)
            throw new NotFoundException();

        return $casoTeste;
    }

    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO): CasoTesteDTO
    {
        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id))
            throw new NotFoundException();

        $validator = Validator::make($casoTesteDTO->toArray(), (new CasoTestePutRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->casoTesteRespository->alterarCasoTeste($casoTesteDTO);
    }
}
