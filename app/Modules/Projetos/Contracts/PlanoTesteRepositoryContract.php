<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteRepositoryContract
{
    public function buscarPlanosTestePorProjeto(int $idProjeto):DataCollection;
    public function buscarPlanoTestePorId(int $idPlanoTeste): ?PlanoTesteDTO;
    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO):PlanoTesteDTO;
    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO):PlanoTesteDTO;
    public function excluirPlanoTeste(int $idPlanoTeste):bool;
}
