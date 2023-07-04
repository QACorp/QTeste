<?php

namespace App\System\Contracts\Repository;

use App\System\DTOs\UserDTO;
use Spatie\LaravelData\DataCollection;

interface UserRepositoryContract
{
    public function buscarTodos():DataCollection;
    public function buscarPorId(int $userId): ?UserDTO;
    public function alterar(UserDTO $userDTO): UserDTO;
    public function salvar(UserDTO $userDTO): UserDTO;
    public function vincularPerfil(array $perfil, int $userId):UserDTO;

    public function alterarEquipeSelecionada(int $idUsuario, int $idEquipe):bool;
}
