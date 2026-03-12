<?php

namespace App\Http\Controllers;

use App\Exports\PurchaseExport;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Supplier;
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
            ->whereNotIn("status_id", [4, 5])
            ->orWhere("payment_status", "Belum Lunas")
            ->get();
        $stocks = Stock::all();
        $payments = Payment::all();
        $suppliers = Supplier::all();

        return view(
            'pages.dashboard.purchase',
            compact(
                'purchases',
                "stocks",
                "payments",
                "suppliers"
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
            ->whereNotIn("status_id", [1, 2, 3, 6])
            ->get();



        return view(
            "pages.dashboard.histories.purchase",
            compact("purchases")
        );
    }

    public function exportList()
    {
        try {
            request()->validate([
                "format" => "required",
            ]);

            $format = (int) request("format");

            $purchase = Purchase::with([
                "user:user_id,user_name",
                "status:status_id,status_description",
                "stock:stocks.*",
            ])
                ->whereNotIn("status_id", [4, 5])
                ->orWhere("payment_status", "Belum Lunas")
                ->get();

            if ($purchase->count() == 0) {
                return back()->with('purchase.error', 'Data pembelian tidak ditemukan.');
            }

            if ($format == 1) {
                return Excel::download(new PurchaseExport($purchase), 'purchases_list.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.purchase', compact('purchase'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Pembelian-List.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with('purchase.error', $th->getMessage());
        }
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
            $status = request("status");

            $purchase = Purchase::with(
                "user:users.*",
                "status:statuses.*",
                "stock:stocks.*"
            );

            // Apply status filter if provided
            if ($status !== null && $status !== "") {
                $status = (int) $status;
                if ($status == 0) {
                     $purchase = $purchase->whereNotIn("status_id", [1, 2, 3, 6]);
                } else {
                     $purchase = $purchase->where("status_id", $status);
                }
            } else {
                $purchase = $purchase->whereNotIn("status_id", [1, 2, 3, 6]);
            }

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
                return Excel::download(new PurchaseExport($purchase), 'purchases.xlsx');
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
            'supplier_id' => 'required',
            'purchase_quantity' => 'required|numeric',
            "purchase_price" => "required|numeric",
            "purchase_total" => "required|numeric",
            "purchase_status" => "required",
            "payment_id" => "required",
        ]);

        $user = session()->get("user");
        $paymentStatus = ((int)request("payment_id") == 1) ? 'Lunas' : 'Belum Lunas';

        Purchase::create([
            "stock_id" => (int) request("stock_id"),
            "supplier_id" => (int) request("supplier_id"),
            "user_id" => (int) $user->user_id,
            "status_id" => (int) request("purchase_status"),
            "purchase_total" => (int) request("purchase_total"),
            "purchase_price" => (int) request("purchase_price"),
            "purchase_quantity" => (int) request("purchase_quantity"),
            "purchase_description" => request("purchase_description") ?? "",
            "payment_id" => (int) request("payment_id"),
            "payment_status" => $paymentStatus,
        ]);

        return back()->with('purchase.success', 'Data pembelian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'stock_id' => 'required',
            'supplier_id' => 'required',
            'purchase_quantity' => 'required|numeric',
            "purchase_price" => "required|numeric",
            "purchase_description" => "required",
            "purchase_status" => "required",
            "payment_id" => "required",
        ]);

        $purchase_total = (int) request("purchase_quantity") * (int) request("purchase_price");
        $paymentStatus = ((int)request("payment_id") == 1) ? 'Lunas' : 'Belum Lunas';

        $purchase = Purchase::where("purchase_id", $id);
        $purchase->update([
            "stock_id" => (int) request("stock_id"),
            "supplier_id" => (int) request("supplier_id"),
            "status_id" => (int) request("purchase_status"),
            "purchase_total" => $purchase_total,
            "purchase_price" => (int) request("purchase_price"),
            "purchase_quantity" => (int) request("purchase_quantity"),
            "purchase_description" => request("purchase_description"),
            "payment_id" => (int) request("payment_id"),
            "payment_status" => $paymentStatus,
        ]);

        return back()->with('purchase.success', 'Data pembelian berhasil diubah.');
    }

    public function pay($id)
    {
        try {
            $purchase = Purchase::where("purchase_id", $id);
            $purchase->update([
                "payment_status" => "Lunas",
            ]);

            return response()->json([
                "status" => true,
                "message" => "Status pembayaran berhasil diubah.",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Status pembayaran gagal diubah.",
            ])->setStatusCode(500);
        }
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

            if ($purchase->first()->payment_status !== "Lunas") {
                return response()->json([
                    "status" => false,
                    "message" => "Data pembelian tidak dapat disetujui karena pembayaran belum lunas.",
                ])->setStatusCode(403);
            }

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
            if ($user->role_id !== 2) {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses untuk menolak data pembelian.",
                ])->setStatusCode(403);
            }

            $purchase = Purchase::where("purchase_id", $id);
            $purchase->update([
                "status_id" => 5,
                "payment_status" => "Lunas",
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
