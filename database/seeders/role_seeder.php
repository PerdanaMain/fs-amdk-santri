<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class role_seeder extends Seeder
{
    public function run(): void
    {
        Role::insert(
            [
                [
                    "role_description" => "Admin",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_description" => "Owner",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_description" => "Sales",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_description" => "Ekspedisi",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_description" => "Auditor",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_description" => "Advisor",
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
            ]
        );
    }
}
