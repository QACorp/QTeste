<?php

namespace App\System\Enuns;

enum RoleEnum:string
{
    case ADMINISTRADOR = 'ADMINISTRADOR';
    case AUDITOR = 'AUDITOR';
    case GESTOR = 'GESTOR';
    case DESENVOLVEDOR = 'DESENVOLVEDOR';
}
