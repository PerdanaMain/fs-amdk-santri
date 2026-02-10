<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class user_seeder extends Seeder
{
    public function run(): void
    {
        // for user table
        User::insert(
            [
                [
                    "role_id" => 1,
                    "user_name" => "NANDA LIRA ANDITA",
                    "user_nik" => "",
                    "user_nip" => "2400001",
                    "user_photo" => null,
                    "user_description" => "",
                    "user_branch" => "Sidoarjo",
                    "user_phone" => "085732274812",
                    "user_address" => "PERUM. PESONASARI RESIDENCE, CANDI",
                    "email" => "nanda@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_id" => 3,
                    "user_name" => "AINUR ROHIM",
                    "user_nik" => "3525101011980000",
                    "user_nip" => "",
                    "user_photo" => null,
                    "user_description" => "",
                    "user_branch" => "Sidoarjo",
                    "user_phone" => "082223850805",
                    "user_address" => "DESA SAWOCANGKRING WONO AYU",
                    "email" => "rohim@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_id" => 3,
                    "user_name" => "MOCH YUSUF EFENDI",
                    "user_nik" => "3515101711960000",
                    "user_nip" => "",
                    "user_photo" => null,
                    "user_description" => "",
                    "user_branch" => "",
                    "user_phone" => "085731372411",
                    "user_address" => "Pagerngumbuk, kec.wonoayu",
                    "email" => "yusuf@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_id" => 3,
                    "user_name" => "TAUFIK HIDAYAT",
                    "user_nik" => "351571205860003",
                    "user_nip" => "",
                    "user_photo" => null,
                    "user_description" => "Training",
                    "user_branch" => "Tanggulangin sidoarjo",
                    "user_phone" => "082220006559",
                    "user_address" => "Klurak candi",
                    "email" => "taufik@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_id" => 4,
                    "user_name" => "ANANTA JELANG RAMADHAN",
                    "user_nik" => "3515081501990000",
                    "user_nip" => "2499005",
                    "user_photo" => null,
                    "user_description" => "",
                    "user_branch" => "Sidoarjo",
                    "user_phone" => "081944102870",
                    "user_address" => "Dusun sampurno rt 17/rw 05 Tanggulangin",
                    "email" => "ananta@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],
                [
                    "role_id" => 2,
                    "user_name" => "Kresna Sutopo",
                    "user_nik" => null,
                    "user_nip" => null,
                    "user_photo" => "591827fb75163bba2d333d3a190a6d2d.png",
                    "user_description" => null,
                    "user_branch" => null,
                    "user_phone" => "081234567890",
                    "user_address" => "Sedati, Sidoarjo",
                    "email" => "kresna@amdksantri.com",
                    "password" => bcrypt("12345"),
                    "created_at" => now(),
                    "updated_at" => now(),
                ],

            ]
        );
    }
}
