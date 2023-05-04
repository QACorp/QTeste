<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface PlanoTesteBusinessContract
{
    public function buscarPlanosTestePorProjeto(int $idProjeto):DataCollection;
    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO):PlanoTesteDTO;
    public function excluirPlanoTeste(int $idPlanoTeste):bool;
}
