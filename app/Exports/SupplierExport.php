<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $suppliers = Supplier::orderBy("supplier_id", "desc")->get();

        $data = $suppliers->map(function ($s) {
            return [
                "No" => $s->supplier_id,
                "Nama Supplier" => $s->supplier_name,
                "Nama Pemilik" => $s->supplier_owner,
                "No Telpon" => $s->supplier_phone,
                "Alamat" => $s->supplier_address,
                "Deskripsi" => $s->supplier_description,
                "Koordinat" => $s->supplier_coordinate ?? '-',
                "Tanggal Dibuat" => $s->created_at->format("Y-m-d"),
            ];
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            "No",
            "Nama Supplier",
            "Nama Pemilik",
            "No Telpon",
            "Alamat",
            "Deskripsi",
            "Koordinat",
            "Tanggal Dibuat",
        ];
    }
}
