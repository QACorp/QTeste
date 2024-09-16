<?php

namespace App\Modules\GestaoEquipe\Alocacao\Enums;

enum NaturezaEnum:string
{
   case SUSTENTACAO = 'Sustentação';
    case MELHORIA = 'Melhoria';
    case PROJETO = 'Projeto';
    case FERIAS = 'Férias';
    case AFASTAMENTO = 'Afastamento';
    case LICENCA = 'Licença';
}
