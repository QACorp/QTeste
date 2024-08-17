<?php

namespace App\System\Contracts\Business;

use App\System\DTOs\EquipeDTO;
use App\System\Requests\EquipePostRequest;
use Spatie\LaravelData\DataCollection;

interface EquipeBusinessContract
{
    public function buscarTodos():DataCollection;
    public function buscarEquipePorId(int $idEquipe):EquipeDTO;
    public function inserir(
        EquipeDTO $equipe,
        EquipePostRequest $equipePostRequest = new EquipePostRequest()):EquipeDTO;
    public function alterar(
        EquipeDTO $equipe,
        EquipePostRequest $equipePostRequest = new EquipePostRequest()):EquipeDTO;
    public function hasEquipe(int $idEquipe, int $idUsuario): bool;
}
