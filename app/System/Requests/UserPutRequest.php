<?php

namespace App\System\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules($userId): array
    {
        return [
            'name' => 'required',
            'email' => [
                Rule::unique('users','email')->ignore($userId),
                'email:rfc,dns'
            ]
        ];
    }
}
