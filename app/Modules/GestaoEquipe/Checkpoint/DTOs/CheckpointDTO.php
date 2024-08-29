<?php

namespace App\Modules\GestaoEquipe\Checkpoint\DTOs;

use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\Required;

class CheckpointDTO extends DTO
{
//Criar DTO com base no model Checkpoint.php
    public ?int $projeto_id;
    public ?int $criador_user_id;
    #[Required]
    public ?int $user_id;
    #[Required]
    public ?string $descricao;
    #[Required]
    public ?Carbon $data;
    public ?string $tarefa;

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
