<?php

namespace App\Domain\Projects\Request;

use App\Domain\Projects\Enum\CloneTypeEnum;
use App\Domain\Projects\Enum\StrategyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Symfony\Contracts\Service\Attribute\Required;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'strategy' => ['required',new Enum(StrategyEnum::class)],
            'url_repository' => 'required',
            'url_git_clone' => 'required',
            'clone_type'    => ['required',new Enum(CloneTypeEnum::class)],
            'user_id'   => 'required|integer|exists:users,id',
            'branchs'   => 'required|array',
            'name'  =>  'required'
        ];
    }
    public function messages()
    {
        return [
                'url_git_clone' => [
                    'required' => 'O campo url_git_clone não pode ser nulo',
                ],
                'name' => [
                    'required' => 'O campo name não pode ser nulo',
                ],
                'branchs' => [
                    'required' => 'O campo branchs não pode ser nulo',
                    'array' => 'O campo branchs é do tipo json e deve seguir este formato: {
                        "main":"master",
                        "develop":"develop",
                        "feature":"feature",
                        "hotfix":"hotfix",
                        "release":"release"
                }',
                ],
                'url_repository' => [
                    'required' => 'O campo url_repository não pode ser nulo',
                ],
                'strategy' => [
                    'required' => 'O campo strategy não pode ser nulo',
                    'Illuminate\Validation\Rules\Enum'  => 'Informe um dos valores: '.implode(', ',StrategyEnum::values())
                ],
                'clone_type' => [
                    'required' => 'O campo clone_type não pode ser nulo',
                    'Illuminate\Validation\Rules\Enum'  => 'Informe um dos valores: '.implode(', ',CloneTypeEnum::values())
                ],
                'user_id' => [
                    'required' => 'O campo user_id não pode ser nulo',
                    'exists'  => 'Informe um usuário existente. ',
                    'integer' => 'O user_id precisa ser um número inteiro.'
                ],

        ];
    }
}
