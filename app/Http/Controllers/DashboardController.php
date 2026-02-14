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

        $summaryData = [
            'labels' => ['Penjualan', 'Pembelian'],
            'data' => [$sales, $purchases],
            'colors' => ['#4B49AC', '#FFC100']
        ];

        // Yearly Data Calculation (Last 5 Years)
        $currentYear = Carbon::now()->year;
        $yearlyLabels = [];
        $yearlySales = [];
        $yearlyPurchases = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $yearlyLabels[] = $year;
            
            $startOfYear = Carbon::create($year, 1, 1)->startOfYear();
            $endOfYear = Carbon::create($year, 12, 31)->endOfYear();

            $yearlySales[] = Sale::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
            $yearlyPurchases[] = Purchase::whereBetween('created_at', [$startOfYear, $endOfYear])->count();
        }

        $yearlyChartData = [
            'labels' => $yearlyLabels,
            'sales' => $yearlySales,
            'purchases' => $yearlyPurchases
        ];

        // Debt and Receivable Calculation
        // Hutang (Payable) -> Belum Lunas Purchases
        $totalPayable = Purchase::where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5)
            ->sum('purchase_total');

        // Piutang (Receivable) -> Belum Lunas Sales
        $totalReceivable = Sale::where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5)
            ->sum('sale_total');

        return view(
            'pages.dashboard.index',
            compact(
                "users",
                "customers",
                "sales",
                "purchases",
                "recentSales",
                "chartData",
                "summaryData",
                "yearlyChartData",
                "totalPayable",
                "totalReceivable"
            )
        );
    }
}
