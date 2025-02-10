<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PessoaJuridicaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'cnpj' => $this->cnpj,
            'razao_social' => $this->razao_social,
            'nome_fantasia' => $this->nome_fantasia,
            'inscricao_estadual' => $this->inscricao_estadual,
            'inscricao_municipal' => $this->inscricao_municipal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
