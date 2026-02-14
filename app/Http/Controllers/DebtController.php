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
}
