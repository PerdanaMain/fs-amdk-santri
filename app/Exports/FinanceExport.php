<?php

namespace App\Exports;

use App\Models\Finance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinanceExport implements FromCollection, WithHeadings
{

    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $finances = Finance::with([
            "purchase:purchases.*",
            "sale:sales.*",
        ]);

        if ($this->start == null && $this->end == null) {
            $finances = $finances->get()
                ->map(function ($f) {
                    return [
                        "ID" => $f->finance_id,
                        "Kode Transaksi" => $f->finance_code,
                        "Type Transaksi" => substr($f->finance_code, 0, 1) == "O"
                        ? "Pembelian" : (substr($f->finance_code, 0, 1) == "S" ? "Penjualan" : "Pembelian"),
                        "Nama Transaksi" => $f->finance_name,
                        "Kredit" => "Rp. " . number_format($f->finance_credit, 0, ",", ".") . ",-",
                        "Debet" => "Rp. " . number_format($f->finance_debet, 0, ",", ".") . ",-",
                        "Deskripsi" => $f->finance_description,
                        "Tanggal Transaksi" => $f->created_at->format("Y-m-d"),
                    ];
                });
        } else {
            $finances = $finances->whereBetween("created_at", [$this->start, $this->end])
                ->get()
                ->map(function ($f) {
                    return [
                        "ID" => $f->finance_id,
                        "Kode Transaksi" => $f->finance_code,
                        "Type Transaksi" => substr($f->finance_code, 0, 1) == "O"
                        ? "Pembelian" : (substr($f->finance_code, 0, 1) == "S" ? "Penjualan" : "Pembelian"),
                        "Nama Transaksi" => $f->finance_name,
                        "Kredit" => "Rp. " . number_format($f->finance_credit, 0, ",", ".") . ",-",
                        "Debet" => "Rp. " . number_format($f->finance_debet, 0, ",", ".") . ",-",
                        "Deskripsi" => $f->finance_description,
                        "Tanggal Transaksi" => $f->created_at->format("Y-m-d"),
                    ];
                });
        }

        return $finances;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Kode Transaksi",
            "Type Transaksi",
            "Nama Transaksi",
            "Kredit",
            "Debet",
            "Deskripsi",
            "Tanggal Transaksi",
        ];
    }
}