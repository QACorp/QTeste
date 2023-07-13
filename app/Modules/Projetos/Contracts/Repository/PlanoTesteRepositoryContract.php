<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteRepositoryContract extends BaseRepositoryContract
{
    public function buscarPlanosTestePorProjeto(int $idProjeto, int $idEquipe):DataCollection;
    public function buscarPlanoTestePorId(int $idPlanoTeste, int $idEquipe): ?PlanoTesteDTO;
    public function buscarTodosPlanoTeste(int $idEquipe): DataCollection;
    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO):PlanoTesteDTO;
    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO):PlanoTesteDTO;
    public function excluirPlanoTeste(int $idPlanoTeste):bool;
}
