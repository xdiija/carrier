<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'pessoa_fisica' => $this->pessoaFisica ? [
                'id' => $this->pessoaFisica->id,
                'cpf' => $this->pessoaFisica->cpf,
                'name' => $this->pessoaFisica->name,
                'birthdate' => $this->pessoaFisica->birthdate,
            ] : null,
            'pessoa_juridica' => $this->pessoaJuridica ? [
                'id' => $this->pessoaJuridica->id,
                'cnpj' => $this->pessoaJuridica->cnpj,
                'razao_social' => $this->pessoaJuridica->razao_social,
                'nome_fantasia' => $this->pessoaJuridica->nome_fantasia,
            ] : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
