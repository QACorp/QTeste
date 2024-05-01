<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface RetrabalhoRepositoryContract
{
    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO;
    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO;
    public function buscarTodosPorEquipe(int $idEquipe):DataCollection;
    public function remover(int $idRetrabalho): bool;
    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO;
}
