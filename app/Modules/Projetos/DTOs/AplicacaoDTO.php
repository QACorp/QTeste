<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class AplicacaoDTO extends DTO
{
    public function __construct(
        public $id,
        public $nome,
        public $descricao
    )
    {
    }
}
