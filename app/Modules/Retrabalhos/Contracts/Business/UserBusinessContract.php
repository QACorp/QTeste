<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\System\Contracts\Business\UserBusinessContract as BaseUserBusinessContract;
use Spatie\LaravelData\DataCollection;

interface UserBusinessContract extends BaseUserBusinessContract
{
    public function listaUsuariosByPermissaoDesenvolvedor():DataCollection;
}
