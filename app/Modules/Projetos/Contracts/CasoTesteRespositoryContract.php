<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface CasoTesteRespositoryContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection;
    public function buscarCasoTestePorString(string $term): ?DataCollection;
    public function buscarCasoTestePorId(int $idCasoTeste): ?CasoTesteDTO;
    public function buscarTodos(): DataCollection;
    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO;
    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO;
    public function existeVinculo(int $idPlanoTeste, int $idCasoTeste):bool;
    public function existeCasoTeste(int $idCasoTeste):bool;
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO):CasoTesteDTO;
    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO):CasoTesteDTO;
    public function excluir(int $idCasoTeste): bool;
}
