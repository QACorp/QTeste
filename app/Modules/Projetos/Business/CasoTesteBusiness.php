<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
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
}
