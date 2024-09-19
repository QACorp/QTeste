<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\Utils\DTO;

class RetrabalhoTarefaDTO extends DTO
{
    public float $proporcao_retrabalho_funcionais;
    public float $proporcao_retrabalho_analise;
    public float $retrabalhos_analise;
    public float $retrabalhos_funcionais;
    public int $tarefa_id;
    public ?string $tarefa;

    public float $retrabalhos;
}
