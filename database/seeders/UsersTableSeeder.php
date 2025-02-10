<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'djalma@example.com',
                'password' => bcrypt('123456'),
                'phone' => '47996216913',
                'status' => 1,
            ],
            [
                'email' => 'leonam@example.com',
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