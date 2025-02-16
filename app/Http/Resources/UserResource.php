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
            'cpf' => $this->cpf,
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
