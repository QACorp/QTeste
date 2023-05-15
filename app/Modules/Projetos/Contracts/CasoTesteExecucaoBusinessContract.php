<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface CasoTesteExecucaoBusinessContract
{
    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status):bool;
    public function casoTesteExecutado(int $idPlanoTesteExecucao, int $idCasoTeste):?CasoTesteExecucaoDTO;
    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao): DataCollection;
}
