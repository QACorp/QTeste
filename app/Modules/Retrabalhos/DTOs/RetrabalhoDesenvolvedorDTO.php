<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Utils\DTO;

class RetrabalhoDesenvolvedorDTO extends DTO
{
    public float $proporcao_retrabalho_funcionais;
    public float $proporcao_retrabalho_analise;
    public float $proporcao_retrabalho;
    public float $retrabalhos_analise;
    public float $retrabalhos_funcionais;
    public int $id;
    public string $name;
    public float $tarefas;

    public float $retrabalhos;
}
