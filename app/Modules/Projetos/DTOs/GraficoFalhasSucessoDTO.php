<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class GraficoFalhasSucessoDTO extends DTO
{
    public function __construct(
        public int $passou,
        public int $falhou
    )
    {
    }
}
