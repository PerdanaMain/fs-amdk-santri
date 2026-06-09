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
                "Supplier" => $p->supplier ? $p->supplier->supplier_name : '-',
                "Jumlah Barang" => (int) $p->purchase_quantity,
                "Harga Barang" => (int) $p->purchase_price,
                "Total Harga" => (int) $p->purchase_total,
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
            "Supplier" => "",
            "Jumlah Barang" => (int) $totalQty,
            "Harga Barang" => null,
            "Total Harga" => (int) $totalPrice,
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
            "Supplier",
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
