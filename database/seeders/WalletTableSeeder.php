<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'balance' => 0
            ],
            [
                'user_id' => 2,
                'balance' => 0
            ]
        ];

        foreach ($data as $wallet) {
            Wallet::create($wallet);
        }
    }
}