<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\PlanoTestePostRequest;
use App\Modules\Projetos\Requests\PlanoTestePutRequest;
use App\Modules\Projetos\Requests\ProjetosPostRequest;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteBusinessContract
{
    public function buscarPlanosTestePorProjeto(int $idProjeto):DataCollection;
    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO, PlanoTestePostRequest $planoTestePostRequest = new PlanoTestePostRequest()):PlanoTesteDTO;
    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO, PlanoTestePutRequest $planoTestePutRequest = new PlanoTestePutRequest()):PlanoTesteDTO;
    public function excluirPlanoTeste(int $idPlanoTeste):bool;
    public function buscarPlanoTestePorId(int $idPlanoTeste): ?PlanoTesteDTO;
    public function buscarTodosPlanoTeste(): DataCollection;
}
