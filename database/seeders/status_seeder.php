<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class status_seeder extends Seeder
{
    public function run(): void
    {
        Status::insert([
            [
                'status_description' => 'Pending Admin Approval',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_description' => 'Approved By Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_description' => 'Pending Owner Approval',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_description' => 'Approved By Owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_description' => 'Rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_description' => 'Draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
