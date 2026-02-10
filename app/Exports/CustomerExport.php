<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function collection()
    {
        if ($this->user_id == 0) {
            $customers = Customer::with([
                "user:user_id,user_name",
                "sales:sales.*",
            ])
                ->orderBy("customer_id", "desc")
                ->get()
                ->map(function ($c) {
                    return [
                        "No" => $c->customer_id,
                        "Petugas" => $c->user->user_name,
                        "Jumlah Transaksi" => $c->sales->count(),
                        "Jumlah Barang Terjual" => $c->sales->sum("sale_quantity"),
                        "Jumlah Total Penjualan" => "Rp. " . number_format($c->sales->sum("sale_total"), 0, ",", ".") . ",-",
                        "Customer Name" => $c->customer_name,
                        "Customer Owner" => $c->customer_owner,
                        "Customer Phone" => $c->customer_phone,
                        "Customer Address" => $c->customer_address,
                        "Customer Description" => $c->customer_description,
                        "Customer Coordinate" => $c->customer_coordinate,
                        "Customer Photo" => $c->customer_photo,
                        "Created At" => $c->created_at->format("Y-m-d"),
                        "Updated At" => $c->updated_at->format("Y-m-d"),
                    ];
                });

        } else {
            $customers = Customer::with([
                "user:user_id,user_name",
                "sales:sales.*",
            ])
                ->where("user_id", $this->user_id)
                ->orderBy("customer_id", "desc")
                ->get()
                ->map(function ($c) {
                    return [
                        "No" => $c->customer_id,
                        "Petugas" => $c->user->user_name,
                        "Jumlah Transaksi" => $c->sales->count(),
                        "Jumlah Barang Terjual" => $c->sales->sum("sale_quantity"),
                        "Jumlah Total Penjualan" => "Rp. " . number_format($c->sales->sum("sale_total"), 0, ",", ".") . ",-",
                        "Customer Name" => $c->customer_name,
                        "Customer Owner" => $c->customer_owner,
                        "Customer Phone" => $c->customer_phone,
                        "Customer Address" => $c->customer_address,
                        "Customer Description" => $c->customer_description,
                        "Customer Coordinate" => $c->customer_coordinate,
                        "Customer Photo" => $c->customer_photo,
                        "Created At" => $c->created_at->format("Y-m-d"),
                        "Updated At" => $c->updated_at->format("Y-m-d"),
                    ];
                });
        }
        return $customers;
    }

    public function headings(): array
    {
        return [
            'No',
            'Petugas',
            "Jumlah Transaksi",
            "Jumlah Barang Terjual",
            "Jumlah Total Penjualan",
            'Customer Name',
            'Customer Owner',
            'Customer Phone',
            'Customer Address',
            'Customer Description',
            'Customer Coordinate',
            'Customer Photo',
            'Created At',
            'Updated At',
        ];
    }
}