<?php

namespace App\Modules\Projetos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetosPostRequest extends FormRequest
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
            'nome' => 'required',
            'descricao' => 'required',
            'inicio' => 'required',
            'termino' => 'required',
            'aplicacao_id' => 'required|exists:App\Modules\Projetos\Models\Aplicacao,id'
        ];
    }
}
