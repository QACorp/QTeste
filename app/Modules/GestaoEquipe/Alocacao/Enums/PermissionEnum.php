<?php

namespace App\Modules\GestaoEquipe\Alocacao\Enums;

enum PermissionEnum:string
{
    case VER_ALOCACAO = 'VER_ALOCACAO';
    case CRIAR_ALOCACAO = 'CRIAR_ALOCACAO';
    case EDITAR_ALOCACAO = 'EDITAR_ALOCACAO';
    case EXCLUIR_ALOCACAO = 'EXCLUIR_ALOCACAO';
    case VER_MINHA_ALOCACAO = 'VER_MINHA_ALOCACAO';
    case CONCLUIR_ALOCACAO = 'CONCLUIR_ALOCACAO';


}
