<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface CasoTesteBusinessContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection;
    public function buscarCasoTestePorString(string $term): ?DataCollection;
    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO;
    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO;
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO):CasoTesteDTO;
}
