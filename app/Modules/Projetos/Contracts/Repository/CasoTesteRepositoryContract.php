<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface CasoTesteRepositoryContract extends BaseRepositoryContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?DataCollection;
    public function buscarCasoTestePorString(string $term, int $idEquipe): ?DataCollection;
    public function buscarCasoTestePorId(int $idCasoTeste, int $idEquipe): ?CasoTesteDTO;
    public function buscarTodos(int $idEquipe): DataCollection;
    public function vincular(int $idPlanoTeste, int $idEquipe, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO;
    public function desvincular(int $idPlanoTeste,int $idEquipe, int $idCasoTeste): PlanoTesteDTO;
    public function existeVinculo(int $idPlanoTeste, int $idCasoTeste, int $idEquipe):bool;
    public function existeCasoTeste(int $idCasoTeste, int $idEquipe):bool;
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO):CasoTesteDTO;
    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO):CasoTesteDTO;
    public function excluir(int $idCasoTeste): bool;
}
