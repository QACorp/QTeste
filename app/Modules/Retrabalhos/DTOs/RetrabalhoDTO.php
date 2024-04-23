<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Support\Validation\ValidationContext;


class RetrabalhoDTO extends DTO
{
    public ?int $id;
    public ?string $descricao;
    #[WithCast(CastCarbonDate::class)]
    public ?Carbon $data;
    public ?string $motivo_exclusao;
    public ?int $numero_tarefa;
    public ?int $id_tipo_retrabalho;
    public ?int $id_usuario_criador;
    public ?int $id_usuario;
    public ?int $id_projeto;
    public ?int $id_aplicacao;
    public ?int $id_caso_teste;
    public static function rules(ValidationContext $context): array
    {
        return [
            'descricao' => 'required'
        ];
    }
}
