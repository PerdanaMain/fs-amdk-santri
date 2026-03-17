<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all()->count();
        $customers = Customer::all()->count();
        $sales = Sale::where("status_id", 2)->get()->count();
        $totalSale = Sale::where("status_id", 2)->sum("sale_total");
        $purchases = Purchase::where("status_id", 4)->get()->count();
        $totalPurchase = Purchase::where("status_id", 4)->sum("purchase_total");
        $suppliers = Supplier::all()->count();

        $products = Stock::query()
            ->leftJoin('sales', function ($join) {
                $join->on('stocks.stock_id', '=', 'sales.stock_id')
                    ->where('sales.status_id', 2);
            })
            ->select('stocks.stock_id', 'stocks.stock_name')
            ->selectRaw('COUNT(sales.sale_id) as total_sale_data')
            ->selectRaw('COALESCE(SUM(sales.sale_total), 0) as total_sale_transactions')
            ->groupBy('stocks.stock_id', 'stocks.stock_name')
            ->orderByDesc('total_sale_transactions')
            ->get();

        $salesByMonth = [];
        $purchaseByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create(null, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create(null, $month, 1)->endOfMonth();

            $salesByMonth[$startOfMonth->format('F')] = Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum("sale_total");
            $purchaseByMonth[$startOfMonth->format('F')] = Purchase::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum("purchase_total");
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

        // Debt and Receivable Calculation
        // Hutang (Payable) -> Belum Lunas Purchases
        $totalPayable = Purchase::where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5)
            ->sum('purchase_total');

        // Piutang (Receivable) -> Belum Lunas Sales
        $totalReceivable = Sale::where("payment_status", "Belum Lunas")
            ->where("status_id", "!=", 5)
            ->sum('sale_total');

        $summaryData = [
            'labels' => ['Penjualan', 'Pembelian', 'Hutang', 'Piutang'],
            'data' => [$totalSale, $totalPurchase, $totalPayable, $totalReceivable],
            'colors' => ['#1F3BB3', '#FFAB00', '#FF4747', '#00D25B']
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

            $yearlySales[] = Sale::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('sale_total');
            $yearlyPurchases[] = Purchase::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('purchase_total');
        }

        $yearlyChartData = [
            'labels' => $yearlyLabels,
            'sales' => $yearlySales,
            'purchases' => $yearlyPurchases
        ];

        return view(
            'pages.dashboard.index',
            compact(
                "users",
                "customers",
                "sales",
                "purchases",
                "chartData",
                "products",
                "summaryData",
                "yearlyChartData",
                "totalPayable",
                "totalReceivable",
                "totalSale",
                "totalPurchase",
                "suppliers",
            )
        );
    }
}
