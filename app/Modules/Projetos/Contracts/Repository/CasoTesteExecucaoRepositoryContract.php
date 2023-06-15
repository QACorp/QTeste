<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface CasoTesteExecucaoRepositoryContract
{
    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status):bool;
    public function buscarCasoTesteExecucao(int $idPlanoTesteExecucao, int $idCasoTeste):?CasoTesteExecucaoDTO;
    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao): DataCollection;
}
