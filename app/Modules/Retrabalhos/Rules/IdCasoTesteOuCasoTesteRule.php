<?php

namespace App\Modules\Retrabalhos\Rules;

use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IdCasoTesteOuCasoTesteRule implements ValidationRule, DataAwareRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $data = [];
    public function __construct(
        private readonly TipoRetrabalhoBusinessContract $tipoRetrabalhoBusiness
    )
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->validateCasoTeste()){
            return;
        }

        $fail("O tipo de retrabalho deve ter um caso de teste.");
    }
    public function validateCasoTeste():bool
    {

        $tipoRetrabalho = $this->tipoRetrabalhoBusiness->getTipoRetrabalhoPorId($this->data['tipo_retrabalho_id']);
        if ($tipoRetrabalho->tipo->value !== TipoRetrabalhoEnum::FUNCIONAL->value) {
            return true;
        }
        if(!empty($this->data['caso_teste_id']) || $this->casoTestePreenchido()) {
            return true;
        }
        return false;

    }

    public function casoTestePreenchido(): bool
    {
        return
            (
                !empty($this->data['titulo_caso_teste']) &&
                !empty($this->data['requisito_caso_teste']) &&
                !empty($this->data['cenario_caso_teste']) &&
                !empty($this->data['teste_caso_teste']) &&
                !empty($this->data['resultado_esperado_caso_teste'])
            );
    }
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
