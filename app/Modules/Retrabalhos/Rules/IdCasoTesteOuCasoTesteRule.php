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
        $tipoRetrabalho = $this->tipoRetrabalhoBusiness->getTipoRetrabalhoPorId($this->data['id_tipo_retrabalho']);
        if ($tipoRetrabalho->tipo != TipoRetrabalhoEnum::FUNCIONAL) {
            return;
        }
        if(!empty($this->data['id_caso_teste']) || $this->casoTestePreenchido()) {
            return;
        }

        $fail("O tipo de retrabalho deve ter um caso de teste.");
    }
    private function casoTestePreenchido(): bool
    {
        return
            (
                !empty($this->data['caso_teste_titulo']) &&
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
