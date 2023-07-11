<?php

namespace App\System\Enums;

enum RoleEnum:string
{
    case ADMINISTRADOR = 'ADMINISTRADOR';
    case AUDITOR = 'AUDITOR';
    case GESTOR = 'GESTOR';
    case DESENVOLVEDOR = 'DESENVOLVEDOR';
}
