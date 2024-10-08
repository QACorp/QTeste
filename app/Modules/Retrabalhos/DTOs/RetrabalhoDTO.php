<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Projetos\DTOs\TarefaDTO;
use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Support\Validation\ValidationContext;


class RetrabalhoDTO extends DTO
{
    public ?int $id;
    public ?string $descricao;
    #[WithCast(CastCarbonDate::class)]
    public ?Carbon $data;
    public ?string $motivo_exclusao;
    public ?int $tarefa_id;
    public ?TarefaDTO $tarefa;
    public ?int $tipo_retrabalho_id;
    public ?int $usuario_criador_id;
    public ?int $usuario_id;
    public ?int $projeto_id;
    public ?int $aplicacao_id;
    public ?int $caso_teste_id;

    public ?CriticidadeEnum $criticidade;
    public static function rules(ValidationContext $context): array
    {
        return [
            'descricao' => 'required'
        ];
    }
}
