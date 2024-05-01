<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use Spatie\LaravelData\DataCollection;

interface RetrabalhoBusinessContract
{
    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idEquipe): RetrabalhoCasoTesteDTO;

    public function buscarPorId(int $idRetrabalho, ?int $idUsuario): ?RetrabalhoCasoTesteDTO;

    public function buscarTodosPorEquipe(int $idEquipe):DataCollection;
    public function buscarTodosPorUsuario(int $idUsuario):DataCollection;
    public function buscarRetrabalho(int $idEquipe, int $idUsuario):DataCollection;
    public function canAlterarRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idUsuario): bool;
    public function canRemoverRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idUsuario): bool;
    public function remover(int $idRetrabalho, ?int $idUsuario): bool;
    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idUsuario, int $idEquipe): RetrabalhoCasoTesteDTO;
}
