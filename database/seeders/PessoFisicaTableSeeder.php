<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PessoFisicaTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'cpf' => '77084419004',
                'name' => 'Djalma Leandro',
                'birthdate' => '1991-01-27',
                'created_at' => now(),
            ],
            [
                'user_id' => 2,
                'cpf' => '66506059052',
                'name' => 'Leonam Moura',
                'birthdate' => '2000-02-25',
                'created_at' => now(),
            ]
        ];

        foreach ($data as $pessoaFisica) {
            DB::table('pessoa_fisica')->insert($pessoaFisica);
        }
    }
}