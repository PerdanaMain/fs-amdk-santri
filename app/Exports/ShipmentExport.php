<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShipmentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $start = request("start_date");
        $end = request("end_date");

        $shipments = Shipment::with([
            "sale.customer",
            "sale.stock",
            "sale.user",
        ]);

        if ($start && $end) {
            $shipments->whereBetween("created_at", [$start, $end]);
        }

        return $shipments->get()->map(function ($s) {
            return [
                "No" => $s->shipment_id,
                "Kode Pengiriman" => $s->shipment_code ?? '-',
                "Nama Customer" => $s->sale->customer->customer_name,
                "Alamat Customer" => $s->sale->customer->customer_address,
                "Nama Barang" => $s->sale->stock->stock_name,
                "Jumlah" => $s->sale->sale_quantity . ' ' . $s->sale->stock->stock_satuan,
                "Status Pengiriman" => $s->shipment_status,
                "Tanggal Dibuat" => $s->created_at->format("Y-m-d"),
            ];
        });
    }

    public function headings(): array
    {
        return [
            "No",
            "Kode Pengiriman",
            "Nama Customer",
            "Alamat Customer",
            "Nama Barang",
            "Jumlah",
            "Status Pengiriman",
            "Tanggal Dibuat",
        ];
    }
}
