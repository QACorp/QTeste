<?php

namespace App\Modules\Projetos\Enums;

enum PlanoTesteExecucaoEnum: string
{
    case PASSOU = 'Passou';
    case FALHOU = 'Falhou';
    case ABANDONADO = 'Abandonado';
    case EM_CORRECAO = 'Em correção';
}
