<?php

namespace App\Modules\Projetos\Requests;

use App\Modules\Projetos\Enums\CasoTesteEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Spatie\LaravelData\Attributes\Validation\Required;

class CasoTestePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'titulo'                => 'required',
            'equipes'               => 'required',
            'teste'                 => 'required',
            'requisito'             => 'required',
            'cenario'               => 'required',
            'resultado_esperado'    => 'required',
            'status'                => [new Required(), new Enum(CasoTesteEnum::class)]
        ];
    }
}
