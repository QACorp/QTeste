<?php

namespace App\Modules\GestaoEquipe\Submodules\Observacao\Enums;

enum PermissionEnum: string
{
    //Criar cases com as permissões de acesso a observacao.
    case LISTAR_OBSERVACAO = 'LISTAR_OBSERVACAO';
    case INSERIR_OBSERVACAO = 'INSERIR_OBSERVACAO';
    case ALTERAR_OBSERVACAO = 'ALTERAR_OBSERVACAO';
    case REMOVER_OBSERVACAO = 'REMOVER_OBSERVACAO';


}
