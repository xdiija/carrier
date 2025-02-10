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
            'pessoa' => $this->pessoaFisica 
                ? new PessoaFisicaResource($this->pessoaFisica) 
                : ($this->pessoaJuridica ? new PessoaJuridicaResource($this->pessoaJuridica): null),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
