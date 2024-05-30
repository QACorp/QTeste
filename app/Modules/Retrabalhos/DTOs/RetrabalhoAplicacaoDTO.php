<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Utils\DTO;

class RetrabalhoAplicacaoDTO extends DTO
{
    public float $proporcao_retrabalho_funcionais;
    public float $proporcao_retrabalho_analise;
    public float $proporcao_retrabalho;
    public float $retrabalhos_analise;
    public float $retrabalhos_funcionais;
    public float $tarefas;
    public int $id_aplicacao;
    public string $nome;

    public float $retrabalhos;
}
