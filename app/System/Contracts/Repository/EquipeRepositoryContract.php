<?php

namespace App\System\Contracts\Repository;

use App\System\DTOs\EquipeDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface EquipeRepositoryContract extends BaseRepositoryContract
{
    public function buscarTodos():DataCollection;
    public function buscarEquipePorId(int $idEquipe):?EquipeDTO;
    public function inserir(EquipeDTO $equipe):EquipeDTO;
    public function alterar(EquipeDTO $equipe):EquipeDTO;

}
