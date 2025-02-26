<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostingPointStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
            ],
            'street' => [
                'required',
                'min:3',
                'max:255',
            ],
            'number' => [
                'required',
                'max:10',
            ],
            'neighborhood' => [
                'required',
                'min:3',
                'max:255',
            ],
            'complement' => [
                'nullable',
                'max:255',
            ],
            'city' => [
                'required',
                'min:2',
                'max:255',
            ],
            'state_id' => [
                'required',
                'integer',
                'exists:states,id',
            ],
            'zip_code' => [
                'required',
                'regex:/^\d{5}-\d{3}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'street.required' => 'O campo rua é obrigatório.',
            'street.min' => 'O campo rua deve ter pelo menos 3 caracteres.',
            'street.max' => 'O campo rua não pode ter mais de 255 caracteres.',
            'number.required' => 'O campo número é obrigatório.',
            'number.max' => 'O campo número não pode ter mais de 10 caracteres.',
            'neighborhood.required' => 'O campo bairro é obrigatório.',
            'neighborhood.min' => 'O campo bairro deve ter pelo menos 3 caracteres.',
            'neighborhood.max' => 'O campo bairro não pode ter mais de 255 caracteres.',
            'complement.max' => 'O campo complemento não pode ter mais de 255 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.min' => 'O campo cidade deve ter pelo menos 2 caracteres.',
            'city.max' => 'O campo cidade não pode ter mais de 255 caracteres.',
            'state_id.required' => 'O campo estado é obrigatório.',
            'state_id.integer' => 'O campo estado deve ser um número inteiro.',
            'state_id.exists' => 'O estado selecionado é inválido.',
            'zip_code.required' => 'O campo CEP é obrigatório.',
            'zip_code.regex' => 'O campo CEP deve estar no formato 00000-000.',
        ];
    }
}
