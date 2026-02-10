<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all()->count();
        $customers = Customer::all()->count();
        $sales = Sale::where("status_id", 2)->get()->count();
        $purchases = Purchase::where("status_id", 4)->get()->count();

        $recentSales = Sale::with(
            "stock:stocks.*",
        )->where("status_id", 2)->orderBy("created_at", "desc")->limit(5)->get();

        $salesByMonth = [];
        $purchaseByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create(null, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create(null, $month, 1)->endOfMonth();

            $salesByMonth[$startOfMonth->format('F')] = Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $purchaseByMonth[$startOfMonth->format('F')] = Purchase::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        $chartData = [
            'labels' => [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ],
            'sales' => [
                $salesByMonth["January"],
                $salesByMonth["February"],
                $salesByMonth["March"],
                $salesByMonth["April"],
                $salesByMonth["May"],
                $salesByMonth["June"],
                $salesByMonth["July"],
                $salesByMonth["August"],
                $salesByMonth["September"],
                $salesByMonth["October"],
                $salesByMonth["November"],
                $salesByMonth["December"],
            ],
            'purchases' => [
                $purchaseByMonth["January"],
                $purchaseByMonth["February"],
                $purchaseByMonth["March"],
                $purchaseByMonth["April"],
                $purchaseByMonth["May"],
                $purchaseByMonth["June"],
                $purchaseByMonth["July"],
                $purchaseByMonth["August"],
                $purchaseByMonth["September"],
                $purchaseByMonth["October"],
                $purchaseByMonth["November"],
                $purchaseByMonth["December"],
            ],
        ];

        return view(
            'pages.dashboard.index',
            compact(
                "users",
                "customers",
                "sales",
                "purchases",
                "recentSales",
                "chartData"
            )
        );
    }
}
