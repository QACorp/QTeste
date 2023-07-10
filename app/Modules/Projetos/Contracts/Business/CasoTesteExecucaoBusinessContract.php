<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\CasoTesteExecucaoDTO;
use Spatie\LaravelData\DataCollection;

interface CasoTesteExecucaoBusinessContract
{
    public function executarCasoTeste(int $idPlanoTesteExecucao, int $idCasoTeste, string $status, int $idEquipe):bool;
    public function casoTesteExecutado(int $idPlanoTesteExecucao, int $idCasoTeste, int $idEquipe):?CasoTesteExecucaoDTO;
    public function buscarTodosCasosTesteExecucaoPorPlanoTesteExecucao(int $idPlanoTesteExecucao, int $idEquipe): DataCollection;
}
