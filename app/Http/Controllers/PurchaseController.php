<?php

namespace App\Http\Controllers;

use App\Exports\PurchaseExport;
use App\Models\Finance;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

        $purchases = Purchase::with([
            "user:user_id,user_name",
            "status:status_id,status_description",
            "stock:stocks.*",
        ])
            ->where("status_id", "!=", 4)
            ->get();
        $stocks = Stock::all();

        return view(
            'pages.dashboard.purchase',
            compact(
                'purchases',
                "stocks"
            )
        );
    }

    public function history()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

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

    public function export()
    {
        try {
            request()->validate([
                "format" => "required",
            ]);

            $format = (int) request("format");
            $start = request("start_date");
            $end = request("end_date");

            $purchase = Purchase::with(
                "user:users.*",
                "status:statuses.*",
                "stock:stocks.*"
            )
                ->where("status_id", 4);

            if ($start == null && $end == null) {
                $purchase = $purchase->orderBy("purchase_id", "desc")
                    ->get();
            } else {
                $purchase = $purchase->whereBetween("created_at", [$start, $end])
                    ->get();
            }

            if ($purchase->count() == 0) {
                return back()->with('purchase.error', 'Data pembelian tidak ditemukan.');
            }

            if ($format == 1) {
                return Excel::download(new PurchaseExport, 'purchases.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.purchase', compact('purchase'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Pembelian.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with('purchase.error', $th->getMessage());
        }
    }

    public function store()
    {
        // validate the request
        request()->validate([
            'stock_id' => 'required',
            'purchase_quantity' => 'required|numeric',
            "purchase_price" => "required|numeric",
            "purchase_total" => "required|numeric",
            "purchase_description" => "required",
            "purchase_status" => "required",
        ]);

        $user = session()->get("user");
        Purchase::create([
            "stock_id" => (int) request("stock_id"),
            "user_id" => (int) $user->user_id,
            "status_id" => (int) request("purchase_status"),
            "purchase_total" => (int) request("purchase_total"),
            "purchase_price" => (int) request("purchase_price"),
            "purchase_quantity" => (int) request("purchase_quantity"),
            "purchase_description" => request("purchase_description"),
        ]);

        return back()->with('purchase.success', 'Data pembelian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'stock_id' => 'required',
            'purchase_quantity' => 'required|numeric',
            "purchase_price" => "required|numeric",
            "purchase_description" => "required",
            "purchase_status" => "required",
        ]);

        $purchase_total = (int) request("purchase_quantity") * (int) request("purchase_price");

        $purchase = Purchase::where("purchase_id", $id);
        $purchase->update([
            "stock_id" => (int) request("stock_id"),
            "status_id" => (int) request("purchase_status"),
            "purchase_total" => $purchase_total,
            "purchase_price" => (int) request("purchase_price"),
            "purchase_quantity" => (int) request("purchase_quantity"),
            "purchase_description" => request("purchase_description"),
        ]);

        return back()->with('purchase.success', 'Data pembelian berhasil diubah.');
    }

    public function destroy($id)
    {
        try {
            $purchase = Purchase::where("purchase_id", $id);
            $purchase->delete();

            return response()->json([
                "status" => true,
                "message" => "Data pembelian berhasil dihapus.",
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Data pembelian gagal dihapus.",
            ])->setStatusCode(500);
        }
    }

    public function submit($id)
    {
        try {
            $purchase = Purchase::where("purchase_id", $id);

            $purchase->update([
                "status_id" => 3,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data pembelian berhasil diajukan.",
            ])->setStatusCode(200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Data pembelian gagal diajukan.",
            ])->setStatusCode(500);
        }
    }

    public function approve($id)
    {
        try {
            $user = session()->get("user");
            if ($user->role_id !== 2) {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses untuk menyetujui data pembelian.",
                ])->setStatusCode(403);
            }

            $purchase = Purchase::where("purchase_id", $id);

            Stock::where("stock_id", $purchase->first()->stock_id)
                ->increment("stock_quantity", $purchase->first()->purchase_quantity);

            $finance = Finance::create([
                "finance_code" => "P-" . rand(1, 99999999),
                "finance_name" => "Pembelian " . $purchase->first()->purchase_description,
                "finance_debet" => 0,
                "finance_credit" => $purchase->first()->purchase_total,
                "finance_description" => "Pembelian " . $purchase->first()->purchase_description,
            ]);

            $purchase->update([
                "status_id" => 4,
                "finance_id" => $finance->finance_id,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data pembelian berhasil disetujui.",
            ])->setStatusCode(200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function reject($id)
    {
        try {
            $user = session()->get("user");
            if ($user->role_id !== 3) {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses untuk menolak data pembelian.",
                ])->setStatusCode(403);
            }

            $purchase = Purchase::where("purchase_id", $id);
            $purchase->update([
                "status_id" => 5,
                "purchase_reject_message" => request("purchase_reject_message"),
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data pembelian berhasil ditolak.",
            ])->setStatusCode(200);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Data pembelian gagal ditolak.",
            ])->setStatusCode(500);
        }
    }
}