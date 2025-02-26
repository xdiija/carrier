<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipientStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'cpf' => [
                'required',
                'cpf', // You might use a custom rule for CPF validation
                Rule::unique('recipients')->ignore($this->id)
            ],
            'phone' => [
                'required',
                'max:15'
            ],
            'street' => [
                'required',
                'max:255'
            ],
            'number' => [
                'required',
                'max:10'
            ],
            'neighborhood' => [
                'required',
                'max:255'
            ],
            'complement' => [
                'nullable',
                'max:255'
            ],
            'city' => [
                'required',
                'max:255'
            ],
            'state_id' => [
                'required',
                'exists:states,id'
            ],
            'zip_code' => [
                'required',
                'max:10'
            ],
        ];

        if ($this->method() === 'PATCH' || $this->method() === 'PUT') {
            // You may want to make some fields optional during update
            $rules['cpf'] = [
                'nullable',
                'cpf',
                Rule::unique('recipients')->ignore($this->id)
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.cpf' => 'O CPF informado é inválido.',
            'cpf.unique' => 'O CPF já está em uso.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.max' => 'O telefone não pode ter mais de 15 caracteres.',
            'street.required' => 'A rua é obrigatória.',
            'street.max' => 'A rua não pode ter mais de 255 caracteres.',
            'number.required' => 'O número é obrigatório.',
            'number.max' => 'O número não pode ter mais de 10 caracteres.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.max' => 'O bairro não pode ter mais de 255 caracteres.',
            'complement.max' => 'O complemento não pode ter mais de 255 caracteres.',
            'city.required' => 'A cidade é obrigatória.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',
            'state_id.required' => 'O estado é obrigatório.',
            'state_id.exists' => 'O estado selecionado é inválido.',
            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.max' => 'O CEP não pode ter mais de 10 caracteres.',
        ];
    }
}
