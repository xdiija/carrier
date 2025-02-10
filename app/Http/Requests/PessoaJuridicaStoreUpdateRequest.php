<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PessoaJuridicaStoreUpdateRequest extends FormRequest
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
            'cnpj' => [
                'required',
                'max:18',
                Rule::unique('pessoa_juridica')->ignore($this->id)
            ],
            'razao_social' => [
                'required', 
                'max:255'
            ],
            'nome_fantasia' => [
                'nullable',
                'max:255'
            ],
            'inscricao_estadual' => [
                'nullable',
                'max:50'
            ],
            'inscricao_municipal' => [
                'nullable',
                'max:50'
                ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.unique' => 'O CNPJ já está em uso.',
            'razao_social.required' => 'O campo razão social é obrigatório.',
        ];
    }
}
