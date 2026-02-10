<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            role_seeder::class,
            user_seeder::class,
            stock_seeder::class,
            status_seeder::class,
            PaymentSeeder::class,
        ]);
    }
}