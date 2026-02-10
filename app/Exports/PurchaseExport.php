<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $purchases = Purchase::with([
            "user:user_id,user_name",
            "status:status_id,status_description",
            "stock:stocks.*",
        ])
            ->where("status_id", 4)
            ->get()
            ->map(function ($p) {
                return [
                    "No" => $p->purchase_id,
                    "Nama Barang" => $p->stock->stock_name,
                    "Jumlah Barang" => $p->purchase_quantity,
                    "Harga Pembelian" => "Rp. " . number_format($p->purchase_price, 0, ",", ".") . ",-",
                    "Total Harga" => "Rp. " . number_format($p->purchase_total, 0, ",", ".") . ",-",
                    "Diajukan Oleh" => $p->user->user_name,
                    "Tanggal Diajukan" => $p->created_at->format("Y-m-d"),
                ];
            });

        return $purchases;
    }

    public function headings(): array
    {
        return [
            "No",
            "Nama Barang",
            "Jumlah Barang",
            "Harga Barang",
            "Total Harga",
            "Diajukan Oleh",
            "Tanggal Diajukan",
        ];
    }
}