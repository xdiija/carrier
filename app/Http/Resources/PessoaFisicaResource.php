<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PessoaFisicaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'cpf' => $this->cpf,
            'name' => $this->name,
            'birthdate' => $this->nascimento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
