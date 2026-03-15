<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        $data = $this->sales->map(function ($s) {
            return [
                "No" => $s->sale_id,
                "Nama Pelanggan" => $s->customer->customer_name,
                "Alamat Pelanggan" => $s->customer->customer_address,
                "Tipe Pembayaran" => $s->payment->payment_name,
                "Tanggal Jatuh Tempo" => $s->sale_date,
                "Nama Barang" => $s->stock->stock_name,
                "Jumlah Barang" => (int) $s->sale_quantity,
                "Harga Barang" => (int) $s->sale_price,
                "Total Harga" => (int) $s->sale_total,
                "PIC Customer" => $s->user->user_name,
                "Status Pembayaran" => $s->payment_status,
                "Status Approval" => $s->status->status_description,
                "Tanggal Dibuat" => $s->created_at->format("Y-m-d"),
            ];
        });

        $totalQty = $this->sales->sum('sale_quantity');
        $totalPrice = $this->sales->sum('sale_total');

        $data->push([
            "No" => "Total",
            "Nama Pelanggan" => "",
            "Alamat Pelanggan" => "",
            "Tipe Pembayaran" => "",
            "Tanggal Jatuh Tempo" => "",
            "Nama Barang" => "",
            "Jumlah Barang" => (int) $totalQty,
            "Harga Barang" => null,
            "Total Harga" => (int) $totalPrice,
            "PIC Customer" => "",
            "Status Pembayaran" => "",
            "Status Approval" => "",
            "Tanggal Dibuat" => "",
        ]);

        return $data;
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
            "Status Pembayaran",
            "Status Approval",
            "Tanggal Dibuat",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold the first row (headings)
            1 => ['font' => ['bold' => true]],

            // Bold the last row (total)
            $sheet->getHighestRow() => ['font' => ['bold' => true]],
        ];
    }
}
