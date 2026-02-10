<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;

class HistoryController extends Controller
{
    public function purchaseIndex()
    {
        $purchases = Purchase::with([
            "user:user_id,user_name",
            "status:status_id,status_description",
            "stock:stocks.*",
        ])
            ->where("status_id", 4)
            ->get();

        return view(
            "pages.dashboard.histories.purchase",
            compact("purchases")
        );
    }

    public function saleIndex()
    {
        $sales = Sale::with([
            "user:user_id,user_name",
            "customer:customer_id,customer_name",
            "status:status_id,status_description",
            "payment:payment_id,payment_description",
        ])
            ->where("status_id", 2)
            ->get();

        return view(
            'pages.dashboard.histories.sale',
            compact(
                'sales',
            )
        );
    }

    public function saleExport()
    {
        try {
            //code...
        } catch (\Throwable $th) {
            return back()->with("history.error", "Failed to export data");
        }
    }
}