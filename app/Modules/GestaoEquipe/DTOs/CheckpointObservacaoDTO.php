<?php

namespace App\Modules\GestaoEquipe\DTOs;

use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;

class CheckpointObservacaoDTO extends DTO
{
    public ?int $id;
    public string $descricao;
    public string $data;
    public ?int $criador_user_id;
    public ?int $user_id;
    public ?int $tarefa_id;
    public ?int $projeto_id;
    public ?ProjetoDTO $projeto;
    public ?TarefaDTO $tarefa;
    public ?UserDTO $user;
    public ?UserDTO $criador;
    public string $tipo;
}
