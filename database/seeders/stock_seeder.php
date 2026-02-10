<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class stock_seeder extends Seeder
{
    public function run(): void
    {
        Stock::insert([
            [
                'stock_name' => 'Gelas 120 ml',
                'stock_photo' => 'fc2991b8a36d2b0f8fe78f89e9177311.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Dus',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Gelas 240 ml',
                'stock_photo' => '2c13a8c74bf2bc2f3f426b5e5a7645a2.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Dus',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Botol 330 ml',
                'stock_photo' => '1f3a41536f185dd2672711652376acdc.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Dus',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Botol 600 ml',
                'stock_photo' => '0e76542f67693c293a352bbf2e42262c.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Dus',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Botol 1500 ml',
                'stock_photo' => 'e561be45de962b2fc1f3b9ccc12b5e45.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Dus',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Galon + isi 19 lt',
                'stock_photo' => '79acf76715a24f2aa7a421dec04c8cb1.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Buah',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                'stock_name' => 'Galon Kosong 19 lt',
                'stock_photo' => '79acf76715a24f2aa7a421dec04c8cb1.png',
                'stock_quantity' => 0,
                'stock_satuan' => 'Buah',
                'stock_description' => '-',
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}