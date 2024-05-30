<?php

namespace App\Modules\Retrabalhos\Enums;

enum CriticidadeEnum: string
{
    case CRITICO = 'Crítico';
    case BAIXA = 'Baixa';
    case MEDIA = 'Média';
    case ALTA = 'Alta';
}
