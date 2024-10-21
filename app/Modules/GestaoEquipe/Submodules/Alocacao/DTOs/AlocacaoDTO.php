<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\NaturezaEnum;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\DTOs\TarefaDTO;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Utils\DTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\BeforeOrEqual;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Contracts\DataCollectable;
use Spatie\LaravelData\Support\Validation\References\FieldReference;

class AlocacaoDTO extends DTO
{
    public ?int $id;
    public ?int $projeto_id;
    #[Required]
    public ?int $user_id;
    public ?int $empresa_id;
    public ?int $equipe_id;
    #[Required, BeforeOrEqual( 'termino')]
    public ?Carbon $inicio;
    #[Required]
    public ?Carbon $termino;
    public ?Carbon $concluida;
    public ?int $tarefa_id;
    public ?TarefaDTO $tarefa;

    public ?Carbon $prorrogacao;
    public ?string $motivo_prorrogacao;
    #[Required]
    public ?NaturezaEnum $natureza;
    public ?string $observacao;
    public ?UserDTO $user;
    public ?EquipeDTO $equipe;
    public ?ProjetoDTO $projeto;
    public ?AlocacaoCancelamentoDTO $cancelamento;

    public static function messages(...$args): array
    {
        return [
            'inicio.before_or_equal' => 'A data de início deve ser anterior ou igual a data de término',
            'user_id.required' => 'O campo user_id é obrigatório',
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

}
