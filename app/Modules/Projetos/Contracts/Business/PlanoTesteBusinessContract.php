<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\PlanoTestePostRequest;
use App\Modules\Projetos\Requests\PlanoTestePutRequest;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteBusinessContract
{
    public function buscarPlanosTestePorProjeto(int $idProjeto, int $idEquipe):DataCollection;
    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO, int $idEquipe, PlanoTestePostRequest $planoTestePostRequest = new PlanoTestePostRequest()):PlanoTesteDTO;
    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO, int $idEquipe, PlanoTestePutRequest $planoTestePutRequest = new PlanoTestePutRequest()):PlanoTesteDTO;
    public function excluirPlanoTeste(int $idPlanoTeste):bool;
    public function buscarPlanoTestePorId(int $idPlanoTeste, int $idEquipe): ?PlanoTesteDTO;
    public function buscarTodosPlanoTeste(int $idEquipe): DataCollection;
}
