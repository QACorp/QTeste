<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Enums;

enum PermissionEnum: string
{
    case VER_CHECKPOINT = 'VER_CHECKPOINT';
    case CRIAR_CHECKPOINT = 'CRIAR_CHECKPOINT';
    case EDITAR_CHECKPOINT = 'EDITAR_CHECKPOINT';
    case EXCLUIR_CHECKPOINT = 'EXCLUIR_CHECKPOINT';


}
