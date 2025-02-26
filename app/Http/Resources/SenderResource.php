<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SenderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => [
                'street' => $this->street,
                'number' => $this->number,
                'neighborhood' => $this->neighborhood,
                'complement' => $this->complement,
                'city' => $this->city,
                'state' => [
                    'id' => $this->state->id,
                    'name' => $this->state->name,
                    'abbreviation' => $this->state->abbreviation,
                ],
                'zip_code' => $this->zip_code,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
