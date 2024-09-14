<?php

namespace App\Modules\Projetos\DTOs;

use App\System\Utils\DTO;
use Symfony\Contracts\Service\Attribute\Required;

class TarefaDTO extends DTO
{
    public ?int $id;
    #[Required]
    public ?string $titulo;
    #[Required]
    public ?string $tarefa;
    public ?int $empresa_id;

}
