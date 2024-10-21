<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\NaturezaEnum;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\User;
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

class AlocacaoCancelamentoDTO extends DTO
{
    public ?int $id;
    public int $alocacao_id;
    public int $user_id;
    public string $motivo;
    public ?UserDTO $user;
    public ?AlocacaoDTO $alocacao;
    public static function messages(...$args): array
    {
        return [
            'inicio.before_or_equal' => 'A data de início deve ser anterior ou igual a data de término',
            'user_id.required' => 'O campo user_id é obrigatório',
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

}
