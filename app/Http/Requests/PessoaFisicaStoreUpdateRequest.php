<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PessoaFisicaStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'cpf' => [
                'required',
                'min:11',
                'max:11',
                Rule::unique('pessoa_fisica')->ignore($this->id)
            ],
            'name' => [
                'required',
                'min:6',
                'max:100'
            ],
            'birthdate' => [
                'nullable',
                'date'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'name.required' => 'O campo nome é obrigatório.',
            'birthdate.required' => 'O campo nascimento é obrigatório.',
        ];
    }
}
