<?php

namespace App\Modules\GestaoEquipe\DTOs;

use App\System\Utils\DTO;

class RelatorioRetrabalhosDTO extends DTO
{
    public int $total_retrabalhos;
    public int $total_projetos;
    public int $total_tarefas;


}
