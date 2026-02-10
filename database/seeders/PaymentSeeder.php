<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::insert([
            [
                "payment_name" => "Cash",
                "payment_description" => "Cash Payment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "payment_name" => "Jatuh Tempo",
                "payment_description" => "Jatuh Tempi Payment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "payment_name" => "Nitip Barang",
                "payment_description" => "Nitip Barang Payment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}