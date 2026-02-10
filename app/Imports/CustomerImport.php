<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToArray, WithHeadingRow
{

    public function array(array $array)
    {
        $count = 0;
        foreach ($array as $row) {
            if (empty($row["nama_customer"])) {
                continue;
            }

            $user = User::Where("user_name", "LIKE", "%" . $row["petugas_nama_sesuai_sistem"] . "%")->first();

            Customer::insert([
                "user_id" => (int) $user->user_id,
                "customer_name" => $row["nama_customer"],
                "customer_owner" => $row["nama_pemilik"],
                "customer_phone" => $row["telp"],
                "customer_address" => $row["alamat"],
                "customer_coordinate" => $row["koordinat"],
                "customer_description" => $row["keterangan"],
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            $count++;
        }

        return $count;
    }
}
