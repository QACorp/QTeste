<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Rules\IdCasoTesteOuCasoTesteRule;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Support\Validation\ValidationContext;


class RetrabalhoCasoTesteDTO extends DTO
{
    public ?int $id;
    public ?string $descricao;
    #[WithCast(CastCarbonDate::class)]
    public ?Carbon $data;
    public ?string $motivo_exclusao;
    #[Required]
    public ?int $numero_tarefa;
    #[Required]
    public ?int $id_tipo_retrabalho;

    public ?int $id_usuario_criador;
    #[Required]
    public ?int $id_usuario;
    public ?int $id_projeto;
    #[Required]
    public ?int $id_aplicacao;

    public ?int $id_caso_teste;

    public ?string $titulo_caso_teste;
    public ?string $requisito_caso_teste;
    public ?string $cenario_caso_teste;
    public ?string $teste_caso_teste;
    public ?string $resultado_esperado_caso_teste;

    public static function rules(ValidationContext $context): array
    {
        return [
            'descricao' => 'required',
            'id_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
            'titulo_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
            'requisito_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
            'teste_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
            'resultado_esperado_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
            'cenario_caso_teste' => new IdCasoTesteOuCasoTesteRule(App::make(TipoRetrabalhoBusinessContract::class)),
        ];
    }
}
