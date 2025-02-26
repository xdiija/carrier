<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostingPoint;

class PostingPointsTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Ponto de Coleta Exemplo 1',
                'street' => 'Rua exemplo',
                'number' => '100',
                'neighborhood' => 'Bairro Exemplo',
                'complement' => 'Segundo piso',
                'city' => 'Cidade Exemplo',
                'state_id' => 1,
                'zip_code' => '00000000'
            ],
            [
                'name' => 'Ponto de Coleta Exemplo 2',
                'street' => 'Rua exemplo 2',
                'number' => '100',
                'neighborhood' => 'Bairro Exemplo 2',
                'complement' => 'Segundo piso',
                'city' => 'Cidade Exemplo 2',
                'state_id' => 2,
                'zip_code' => '00000000'
            ],
            [
                'name' => 'Ponto de Coleta Exemplo 3',
                'street' => 'Rua exemplo 3',
                'number' => '100',
                'neighborhood' => 'Bairro Exemplo 3',
                'complement' => 'Segundo piso 3',
                'city' => 'Cidade Exemplo 3',
                'state_id' => 3,
                'zip_code' => '00000000'
            ],
        ];

        foreach ($data as $point) {
            PostingPoint::create($point);
        }
    }
}