<?php

namespace App\Exports;

use App\Models\Visit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitExport implements FromCollection, WithHeadings
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
        $user = session()->get('user');

        $visits = Visit::with(
            "customer:customers.*",
            "user:users.*"
        );

        if (in_array($user->role_id, [3])) {
            $visits = $visits->where('user_id', $user->user_id);
        }

        if ($this->start == null && $this->end == null) {
            $visits = $visits->get()
                ->map(function ($v) {
                    return [
                        "ID" => $v->visit_id,
                        "PIC Customer" => $v->user->user_name,
                        "Nama Pelanggan" => $v->customer->customer_name,
                        "Deskripsi" => $v->visit_description,
                        "Foto" => $v->visit_photo,
                        "Tanggal Kunjungan" => $v->created_at->format("d-m-Y"),
                    ];
                });
        } else {
            $visits = $visits->whereBetween("created_at", [$this->start, $this->end])
                ->get()
                ->map(function ($v) {
                    return [
                        "ID" => $v->visit_id,
                        "PIC Customer" => $v->user->user_name,
                        "Nama Pelanggan" => $v->customer->customer_name,
                        "Deskripsi" => $v->visit_description,
                        "Foto" => $v->visit_photo,
                        "Tanggal Kunjungan" => $v->created_at->format("d-m-Y"),
                    ];
                });
        }

        return $visits;
    }

    public function headings(): array
    {
        return [
            "ID",
            "PIC Customer",
            "Nama Pelanggan",
            "Deskripsi",
            "Foto",
            "Tanggal Kunjungan",
        ];
    }
}
