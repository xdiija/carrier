<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'djalma@example.com',
                'password' => bcrypt('123456'),
                'phone' => '47996216913',
                'cpf' => '07597599951',
                'name' => 'Djalma Leandro',
                'status' => 1,
            ],
            [
                'name' => 'Leonam Sobrenome',
                'email' => 'leonam@example.com',
                'cpf' => '95550310023',
                'password' => bcrypt('123456'),
                'phone' => '88999999999',
                'status' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}