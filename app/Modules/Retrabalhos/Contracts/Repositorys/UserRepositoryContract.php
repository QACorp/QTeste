<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use Spatie\LaravelData\DataCollection;
use App\System\Contracts\Repository\UserRepositoryContract as BaseUserRepositoryContract;
interface UserRepositoryContract extends BaseUserRepositoryContract
{
    public function listaUsuariosByPermissaoDesenvolvedor():DataCollection;
}
