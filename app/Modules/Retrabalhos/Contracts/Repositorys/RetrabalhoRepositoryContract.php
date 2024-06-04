<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface RetrabalhoRepositoryContract
{
    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO;
    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO;
    public function buscarTodosPorEquipe(int $idEquipe):DataCollection;
    public function remover(int $idRetrabalho): bool;
    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO;
    public function buscarTodosPorUsuario(int $idUsuario): DataCollection;
    public function buscarRetrabalhoPorCasoTeste(CasoTesteDTO $casoTesteDTO):DataCollection;
}
