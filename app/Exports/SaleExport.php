<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $sales = Sale::with([
            "user:users.*",
            "customer:customers.*",
            "status:statuses.*",
            "payment:payments.*",
        ])
            ->where("status_id", 2)
            ->get()
            ->map(function ($s) {
                return [
                    "No" => $s->sale_id,
                    "Nama Pelanggan" => $s->customer->customer_name,
                    "Alamat Pelanggan" => $s->customer->customer_address,
                    "Pembayaran" => $s->payment->payment_name,
                    "Jatuh Tempo" => $s->sale_date,
                    "Nama Barang" => $s->stock->stock_name,
                    "Jumlah Barang" => $s->sale_quantity,
                    "Harga Barang" => "Rp. " . number_format($s->sale_price, 0, ",", ".") . ",-",
                    "Total Harga" => "Rp. " . number_format($s->sale_total, 0, ",", ".") . ",-",
                    "PIC Customer" => $s->user->user_name,
                    "Tanggal Dibuat" => $s->created_at->format("Y-m-d"),
                ];
            });
        return $sales;
    }

    public function headings(): array
    {
        return [
            "No",
            "Nama Pelanggan",
            "Alamat Pelanggan",
            "Tipe Pembayaran",
            "Tanggal Jatuh Tempo",
            "Nama Barang",
            "Jumlah Barang",
            "Harga Barang",
            "Total Harga",
            "PIC Customer",
            "Tanggal Dibuat",
        ];
    }
}