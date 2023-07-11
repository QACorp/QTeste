<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class TotaisTestesDTO extends DTO
{
    public function __construct(
        public int $total_aplicacoes,
        public int $total_planos_teste,
        public int $total_casos_teste,
        public int $total_projetos
    )
    {
    }
}
