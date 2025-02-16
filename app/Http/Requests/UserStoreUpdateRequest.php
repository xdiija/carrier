<?php

namespace App\Http\Requests;

use App\Helpers\CnpjHelper;
use App\Helpers\CpfHelper;
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
            'pessoa_fisica' => [
                'array',
                'required_without:pessoa_juridica',
            ],
            'pessoa_juridica' => [
                'array',
                'required_without:pessoa_fisica',
            ],
        ];

        $rules = array_merge($rules, $this->rulesPF(), $this->rulesPJ());

        if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['password'] = [
                'nullable',
                'min:6',
                'max:100'
            ];
        }

        return $rules;
    }

    protected function rulesPJ(): array
    {
        if($this->pessoa_juridica){
            return [
                'pessoa_juridica.cnpj' => [
                    'required',
                    new ValidCnpj(),
                    Rule::unique('pessoa_juridica')->ignore($this->id, 'user_id')
                ],
                'pessoa_juridica.razao_social' => [
                    'required', 
                    'max:255'
                ],
                'pessoa_juridica.nome_fantasia' => [
                    'required',
                    'max:255'
                ],
                'pessoa_juridica.inscricao_estadual' => [
                    'nullable',
                    'max:50'
                ],
                'pessoa_juridica.inscricao_municipal' => [
                    'nullable',
                    'max:50'
                ]
            ];
        }

        return [];
    }

    protected function rulesPF(): array
    {
        if($this->pessoa_fisica){
            return [
                'pessoa_fisica.cpf' => [
                    'required',
                    new ValidCpf(),
                    Rule::unique('pessoa_fisica')->ignore($this->id, 'user_id')
                ],
                'pessoa_fisica.name' => [
                    'required',
                    'min:6',
                    'max:100'
                ],
                'pessoa_fisica.birthdate' => [
                    'nullable',
                    'date'
                ],
            ];
        }

        return [];
    }

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
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status deve ser um número inteiro.',
            'status.in' => 'O campo status deve ser 1 ou 2.',
            'pessoa_fisica.cpf.required' => 'O campo CPF é obrigatório.',
            'pessoa_fisica.cpf.unique' => 'CPF já está em uso',
            'pessoa_fisica.name.required' => 'O campo nome é obrigatório.',
            'pessoa_fisica.name.min' => 'O nome deve ter pelo menos 6 caracteres.',
            'pessoa_fisica.name.max' => 'O nome não pode ter mais de 100 caracteres.',
            'pessoa_fisica.birthdate.date' => 'Data inválida.',
            'pessoa_fisica.required_without'=> 'O campo pessoa física é obrigatório quando pessoa jurídica não estiver presente',
            'pessoa_juridica.cnpj.required' => 'O campo CNPJ é obrigatório.',
            'pessoa_juridica.cnpj.unique' => 'CNPJ já esta em uso.',
            'pessoa_juridica.razao_social.required' => 'Razão Social é obrigatório.',
            'pessoa_juridica.razao_social.max' => 'Razão Social não pode ter mais de 255 caracteres.',
            'pessoa_juridica.nome_fantasia.max' => 'Nome Fantasia não pode ter mais de 255 caracteres.',
            'pessoa_juridica.nome_fantasia.required' => 'Nome Fantasia é obrigatório.',
            'pessoa_juridica.inscricao_estadual.max' => 'Inscrição Estadual não pode ter mais de 50 caracteres.',
            'pessoa_juridica.inscricao_municipal.max' => 'Inscrição Municipal não pode ter mais de 50 caracteres.',
            'pessoa_juridica.required_without' => 'O campo pessoa jurídica é obrigatório quando pessoa física não estiver presente'
        ];
    }
}
