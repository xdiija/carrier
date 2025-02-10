<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id)
            ],
            'password' => [
                'required',
                'min:6',
                'max:100'
            ],
            'phone' => [
                'required',
                'min:6',
                'max:100'
            ],
            'status' => [
                'required',
                'integer',
                'in:1,2'
            ],
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['password'] = [
                'nullable',
                'min:6',
                'max:100'
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email informado é inválido!',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.max' => 'A senha não pode ter mais de 100 caracteres.',
            'phone.required' => 'O campo nome é obrigatório.',
            'phone.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'phone.max' => 'O nome não pode ter mais de 255 caracteres.',
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status deve ser um número inteiro.',
            'status.in' => 'O campo status deve ser 1 ou 2.',
        ];
    }
}
