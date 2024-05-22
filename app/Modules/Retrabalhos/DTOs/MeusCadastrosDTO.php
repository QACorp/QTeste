<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Utils\DTO;
use Carbon\Carbon;

class MeusCadastrosDTO extends DTO
{
    public ?float $id;
    public ?string $numero_tarefa;
    public ?Carbon $data;
    public ?string $nome_aplicacao;
    public ?string $nome_projeto;
    public ?string $nome;
}
