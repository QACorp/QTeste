<?php

namespace App\Modules\GestaoEquipe\Checkpoint\DTOs;

use App\Modules\GestaoEquipe\Alocacao\DTOs\AlocacaoDTO;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\Required;

class CheckpointDTO extends DTO
{
    public ?int $id;
    public ?int $projeto_id;
    public ?int $alocacao_id;
    public ?int $criador_user_id;
    public ?int $equipe_id;
    #[Required]
    public ?int $user_id;
    #[Required]
    public ?Carbon $data;
    public ?int $tarefa_id;
    public ?TarefaDTO $tarefa;
    public ?ProjetoDTO $projeto;
    public ?UserDTO $user;
    public ?UserDTO $criador;
    public ?AlocacaoDTO $alocacao;
    #[Required]
    public ?string $descricao;

    public ?bool $compareceu = false;

    //Criar método com as mensagens de validação
    public static function messages(...$args): array
    {
        return [
            'user_id.required' => 'O usuário é obrigatório',
            'descricao.required' => 'A descrição é obrigatória',
            'data.required' => 'A data é obrigatória'
        ];
    }
}
