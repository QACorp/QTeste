<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteRepositoryContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
use App\Modules\Projetos\Requests\PlanoTestePostRequest;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class PlanoTesteBusiness implements PlanoTesteBusinessContract
{
    public function __construct(
        private readonly PlanoTesteRepositoryContract $planoTesteRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarPlanosTestePorProjeto(int $idProjeto): DataCollection
    {
        return $this->planoTesteRepository->buscarPlanosTestePorProjeto($idProjeto);
    }

    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO): PlanoTesteDTO
    {
        if($this->projetoBusiness->buscarPorIdProjeto($planoTesteDTO->projeto_id) == null)
            throw new NotFoundException();

        $validator = Validator::make($planoTesteDTO->toArray(), (new PlanoTestePostRequest())->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->planoTesteRepository->salvarPlanoTeste($planoTesteDTO);
    }

    public function excluirPlanoTeste(int $idPlanoTeste): bool
    {
        if($this->planoTesteRepository->buscarPlanoTestePorId($idPlanoTeste) == null)
            throw new NotFoundException();
        return $this->planoTesteRepository->excluirPlanoTeste($idPlanoTeste);
    }
}
