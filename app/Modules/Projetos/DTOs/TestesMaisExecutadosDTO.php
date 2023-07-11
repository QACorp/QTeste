<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class TestesMaisExecutadosDTO extends DTO
{
    public function __construct(
        public int $id,
        public string $titulo,
        public string $requisito,
        public string $cenario,
        public string $teste,
        public string $resultado_esperado,
        public string $status,
        public int $total_execucoes
    )
    {
    }
}
