<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use Spatie\LaravelData\DataCollection;

interface CasoTesteBusinessContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection;
    public function buscarCasoTestePorString(string $term): ?DataCollection;
    public function buscarCasoTestePorId(int $idCasoTeste): ?CasoTesteDTO;
    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO;
    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO;
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePostRequest $casoTestePostRequest = new CasoTestePostRequest()):CasoTesteDTO;
    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePutRequest $casoTestePutRequest = new CasoTestePutRequest()):CasoTesteDTO;
    public function buscarTodos(): DataCollection;
    public function excluir(int $idCasoTeste): bool;
}
