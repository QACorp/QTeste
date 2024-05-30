<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\Utils\DTO;

class RetrabalhoUsuarioDadosDTO extends DTO
{
    public ?string $nome_aplicacao;
    public ?int $aplicacao_id;
    public ?int $total;
    public ?int $mes;

}
