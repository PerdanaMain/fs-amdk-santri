<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function indexHutang()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

        $purchases = Purchase::with([
            "user:user_id,user_name",
            "status:status_id,status_description",
            "stock:stocks.*",
            "payment:payment_id,payment_name"
        ])
            ->where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5) // Exclude rejected
            ->get();

        return view(
            'pages.dashboard.debts.payable',
            compact('purchases')
        );
    }

    public function indexPiutang()
    {
        $user = session()->get('user');
        
        $sales = Sale::with([
            "user:user_id,user_name",
            "status:status_id,status_description",
            "stock:stocks.*",
            "customer:customers.*",
            "payment:payment_id,payment_name"
        ])
            ->where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5) // Exclude rejected
            ->get();

        return view(
            'pages.dashboard.debts.receivable',
            compact('sales')
        );
    }

    public function exportHutang()
    {
        try {
            request()->validate([
                "format" => "required",
            ]);

            $format = (int) request("format");
            $purchases = Purchase::with([
                "user:user_id,user_name",
                "status:status_id,status_description",
                "stock:stocks.*",
                "payment:payment_id,payment_name"
            ])
                ->where("payment_status", "Belum Lunas")
                ->where("status_id", "!=", 5)
                ->get();

            if ($purchases->count() == 0) {
                return back()->with('purchase.error', 'Data hutang tidak ditemukan.');
            }

            if ($format == 1) {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PurchaseExport($purchases), 'hutang.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.purchase', ['purchase' => $purchases])
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Hutang.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with('purchase.error', $th->getMessage());
        }
    }

    public function exportPiutang()
    {
        try {
            request()->validate([
                "format" => "required",
            ]);

            $format = (int) request("format");
            $sales = Sale::with([
                "user:user_id,user_name",
                "status:status_id,status_description",
                "stock:stocks.*",
                "customer:customers.*",
                "payment:payment_id,payment_name"
            ])
                ->where("payment_status", "Belum Lunas")
                ->where("status_id", "!=", 5)
                ->get();

            if ($sales->count() == 0) {
                return back()->with('sale.error', 'Data piutang tidak ditemukan.');
            }

            if ($format == 1) {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SaleExport($sales), 'piutang.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.sale', compact('sales'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Piutang.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with('sale.error', $th->getMessage());
        }
    }
}
