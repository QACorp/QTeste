<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;

class CasoTesteDTO extends DTO
{
    public function __construct(
        public ?int $id,
        public ?string $titulo,
        public ?string $requisito,
        public ?string $cenario,
        public ?string $teste,
        public ?string $resultado_esperado,
        public ?string $status
    )
    {
    }
}
