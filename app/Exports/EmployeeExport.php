<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $employees = User::with(
            [
                "role:roles.*",
                "customers:customers.*",
                "sales:sales.*",
            ]
        )
            ->where("role_id", "!=", 2)
            ->where([
                ["status", "!=", "dipecat"],
                ["status", "!=", "resign"],
            ])
            ->get()
            ->map(function ($e) {
                return [
                    "No" => $e->user_id,
                    "Role" => $e->role->role_description,
                    "Name" => $e->user_name,
                    "Status" => $e->status,
                    "Email" => $e->email,
                    "Phone" => $e->user_phone,
                    "Jumlah Customer" => $e->customers->count(),
                    "Jumlah Transaksi" => $e->sales->count(),
                    "Address" => $e->user_address,
                    "Branch" => $e->user_branch,
                    "Photo" => $e->user_photo,
                    "Created At" => $e->created_at->format("Y-m-d"),
                    "Updated At" => $e->updated_at->format("Y-m-d"),
                ];
            });
        return $employees;
    }

    public function headings(): array
    {
        return [
            "No",
            "Role",
            "Name",
            "Status",
            "Email",
            "Phone",
            "Jumlah Customer",
            "Jumlah Transaksi",
            "Address",
            "Branch",
            "Photo",
            "Created At",
            "Updated At",
        ];
    }
}