<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SenderStoreUpdateRequest extends FormRequest
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
                'string',
                'max:255',
            ],
            'cpf' => [
                'required',
                'string',
                'size:14',
                Rule::unique('senders')->ignore($this->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
            ],
            'street' => [
                'required',
                'string',
                'max:255',
            ],
            'number' => [
                'required',
                'string',
                'max:10',
            ],
            'neighborhood' => [
                'required',
                'string',
                'max:255',
            ],
            'complement' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
            'state_id' => [
                'required',
                'exists:states,id',
            ],
            'zip_code' => [
                'required',
                'string',
                'max:10',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.size' => 'O CPF deve conter exatamente 14 caracteres.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email informado é inválido.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'state_id.exists' => 'O estado selecionado é inválido.',
            'zip_code.required' => 'O campo CEP é obrigatório.',
        ];
    }
}
