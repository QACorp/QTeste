<?php

namespace App\Modules\Projetos\Enums;

enum CasoTesteEnum: string
{
    case EM_CRIACAO = 'Em criação';
    case EM_REVISAO = 'Em revisão';
    case CONCLUIDO = 'Concluído';
}
