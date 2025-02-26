<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(WalletTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(PostingPointsTableSeeder::class);
    }
}
