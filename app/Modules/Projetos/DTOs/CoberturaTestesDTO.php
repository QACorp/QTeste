<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class CoberturaTestesDTO extends DTO
{
    public function __construct(
        public int $id,
        public string $nome,
        public int $total_testes
    )
    {
    }
}
