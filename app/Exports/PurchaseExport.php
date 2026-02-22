<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $purchases;

    public function __construct($purchases)
    {
        $this->purchases = $purchases;
    }

    public function collection()
    {
        $data = $this->purchases->map(function ($p) {
            return [
                "No" => $p->purchase_id,
                "Nama Barang" => $p->stock->stock_name,
                "Jumlah Barang" => $p->purchase_quantity,
                "Harga Pembelian" => "Rp. " . number_format($p->purchase_price, 0, ",", ".") . ",-",
                "Total Harga" => "Rp. " . number_format($p->purchase_total, 0, ",", ".") . ",-",
                "Diajukan Oleh" => $p->user->user_name,
                "Tanggal Diajukan" => $p->created_at->format("Y-m-d"),
                "Status" => $p->status->status_description,
                "Status Pembayaran" => $p->payment_status,
            ];
        });

        $totalQty = $this->purchases->sum('purchase_quantity');
        $totalPrice = $this->purchases->sum('purchase_total');

        $data->push([
            "No" => "Total",
            "Nama Barang" => "",
            "Jumlah Barang" => $totalQty,
            "Harga Pembelian" => "",
            "Total Harga" => "Rp. " . number_format($totalPrice, 0, ",", ".") . ",-",
            "Diajukan Oleh" => "",
            "Tanggal Diajukan" => "",
            "Status" => "",
            "Status Pembayaran" => "",
        ]);

        return $data;
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
            "Status",
            "Status Pembayaran",
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