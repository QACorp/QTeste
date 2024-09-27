<?php

namespace App\Modules\GestaoEquipe\Observacao\DTOs;

use App\Modules\GestaoEquipe\Alocacao\DTOs\AlocacaoDTO;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\Required;

class ObservacaoDTO extends DTO
{
    #[Required]
    public ?int $user_id;
    #[Required]
    public ?int $criador_user_id;
    #[Required]
    public string $descricao;
    #[Required]
    public Carbon $data;

    public ?UserDTO $user;
    public ?UserDTO $criador;


    //Criar método com as mensagens de validação
    public static function messages(...$args): array
    {
        return [
            'user_id.required' => 'O usuário é obrigatório',
            'criador_user_id.required' => 'O usuário criador é obrigatório',
            'descricao.required' => 'A descrição é obrigatória',
            'data.required' => 'A data é obrigatória'
        ];
    }
}
