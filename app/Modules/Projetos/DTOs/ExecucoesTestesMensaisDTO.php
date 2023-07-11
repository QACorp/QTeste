<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class ExecucoesTestesMensaisDTO extends DTO
{
    public function __construct(
        public string $data,
        public int $quantidade
    )
    {
    }
}
