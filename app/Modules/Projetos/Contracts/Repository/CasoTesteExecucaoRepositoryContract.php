<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface CasoTesteExecucaoRepositoryContract extends BaseRepositoryContract
{
    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status, int $idEquipe):bool;
    public function buscarCasoTesteExecucao(int $idPlanoTesteExecucao, int $idCasoTeste, int $idEquipe):?CasoTesteExecucaoDTO;
    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao, int $idEquipe): DataCollection;
}
