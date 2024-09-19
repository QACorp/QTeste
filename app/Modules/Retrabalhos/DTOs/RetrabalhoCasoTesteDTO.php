<?php

namespace App\Modules\Retrabalhos\DTOs;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
use App\Modules\Retrabalhos\Models\Projeto;
use App\Modules\Retrabalhos\Models\User;
use App\Modules\Retrabalhos\Rules\IdCasoTesteOuCasoTesteRule;
use App\System\Casts\CastCarbonDate;
use App\System\Utils\DTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\ValidationContext;
class RetrabalhoCasoTesteDTO extends DTO
{
    public ?int $id;
    #[Required]
    public ?string $descricao;
    #[WithCast(CastCarbonDate::class)]
    public ?Carbon $data;
    public ?string $motivo_exclusao;
    #[Required]
    public ?int $tarefa_id;
    #[Required]
    public ?int $tipo_retrabalho_id;

    public ?int $usuario_criador_id;
    #[Required]
    public ?int $usuario_id;

    public ?int $projeto_id;

    #[Required]
    public ?int $aplicacao_id;

    public ?int $caso_teste_id;

    #[Required]
    public ?CriticidadeEnum $criticidade;
    public ?TarefaDTO $tarefa;
    #[WithoutValidation]
    #[WithCast(CasoTeste::class)]
    public ?CasoTesteDTO $caso_teste;
    #[WithoutValidation]
    #[WithCast(Aplicacao::class)]
    public ?AplicacaoDTO $aplicacao;
    #[WithoutValidation]
    #[WithCast(Projeto::class)]
    public ?ProjetoDTO $projeto;
    #[WithoutValidation]
    #[WithCast(User::class)]
    public ?UserDTO $usuario;
    #[WithoutValidation]
    #[WithCast(User::class)]
    public ?UserDTO $usuario_criador;

    public ?TipoRetrabalhoDTO $tipo_retrabalho;

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
