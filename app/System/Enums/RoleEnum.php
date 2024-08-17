<?php

namespace App\System\Enums;

enum RoleEnum:string
{
    case ADMINISTRADOR = 'ADMINISTRADOR';
    case AUDITOR = 'AUDITOR';
    case GESTOR = 'GESTOR';
    case DESENVOLVEDOR = 'DESENVOLVEDOR';
    case ADMINISTRADOR_API = 'ADMINISTRADOR_API';
    case AUDITOR_API = 'AUDITOR_API';
    case GESTOR_API = 'GESTOR_API';
    case DESENVOLVEDOR_API = 'DESENVOLVEDOR_API';
}
