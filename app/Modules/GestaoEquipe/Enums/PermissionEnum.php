<?php

namespace App\Modules\GestaoEquipe\Enums;

enum PermissionEnum:string
{
    case VER_ALOCACAO = 'VER_ALOCACAO';
    case CRIAR_ALOCACAO = 'CRIAR_ALOCACAO';
    case ALTERAR_ALOCACAO = 'ALTERAR_ALOCACAO';
    case EXCLUIR_ALOCACAO = 'EXCLUIR_ALOCACAO';
    case VER_MINHA_ALOCACAO = 'VER_MINHA_ALOCACAO';


}
