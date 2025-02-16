<?php

namespace App\Http\Requests;

use App\Rules\ValidCnpj;
use App\Rules\ValidCpf;
use App\Rules\ValidPhone;
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
            'name' => [
                'required',
                'min:6',
                'max:100'
            ],
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
                new ValidPhone(),
                'max:100'
            ],
            'status' => [
                'required',
                'integer',
                'in:1,2'
            ],
            'cnpj' => [
                'required_without:cpf',
                new ValidCnpj(),
                Rule::unique('users')->ignore($this->id)
            ],
            'cpf' => [
                'required_without:cnpj',
                new ValidCpf(),
                Rule::unique('users')->ignore($this->id)
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

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 6 caracteres.',
            'name.max' => 'O nome não pode ter mais de 100 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O email informado é inválido!',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.max' => 'A senha não pode ter mais de 100 caracteres.',
            'phone.required' => 'O campo nome é obrigatório.',
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status deve ser um número inteiro.',
            'status.in' => 'O campo status deve ser 1 ou 2.',
            'cpf.required_without' => 'Preencha pelo menos o CPF ou CNPJ.',
            'cnpj.required_without' => 'Preencha pelo menos o CPF ou CNPJ.',
            'cpf.unique' => 'CPF já está em uso',
            'cnpj.unique' => 'CNPJ já está em uso',
        ];
    }
}
