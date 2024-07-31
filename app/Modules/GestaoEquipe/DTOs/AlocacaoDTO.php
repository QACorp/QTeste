<?php

namespace App\Modules\GestaoEquipe\DTOs;

use App\Modules\GestaoEquipe\Enums\NaturezaEnum;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Contracts\DataCollectable;

class AlocacaoDTO extends DTO
{
    public ?int $projeto_id;
    public ?int $user_id;
    public ?int $empresa_id;
    public ?int $equipe_id;
    public ?Carbon $inicio;
    public ?Carbon $termino;
    public ?Carbon $concluida;
    public ?string $tarefa;
    public ?NaturezaEnum $natureza;
    public ?string $observacao;
    public ?UserDTO $user;
    public ?EquipeDTO $equipe;
    public ?ProjetoDTO $projeto;
    public function rules(): array
    {
        return [
            'projeto_id' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'equipe_id' => 'required',
            'inicio' => 'required|date|before:termino',
            'inicio' => 'required,',
            'termino' => 'required',
            'natureza' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'projeto_id.required' => 'O campo projeto_id é obrigatório',
            'user_id.required' => 'O campo user_id é obrigatório',
            'empresa_id.required' => 'O campo empresa_id é obrigatório',
            'equipe_id.required' => 'O campo equipe_id é obrigatório',
            'inicio.required' => 'O campo inicio é obrigatório',
            'inicio.before' => 'O campo inicio deve ser anterior ao campo termino',
            'termino.required' => 'O campo termino é obrigatório',
            'natureza.required' => 'O campo natureza é obrigatório',
        ];
    }
}
