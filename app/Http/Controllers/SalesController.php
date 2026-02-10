<?php

namespace App\Http\Controllers;

use App\Exports\SaleExport;
use App\Models\Customer;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Shipment;
use App\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [4])) {
            return redirect()->route('dashboard');
        }

        $customers = [];
        $payments = Payment::all();
        $stocks = Stock::all();
        $sales = Sale::with(
            "customer",
            "payment",
            "stock",
            "status",
            "user"
        );

        if (in_array($user->role_id, [1, 2, 4, 5, 6])) {

            $sales = $sales
                ->where("status_id", "!=", 2)
                ->orderBy("sale_id", "desc")
                ->get();

            $customers = Customer::with(
                "user:users.*",
            )->get();
        } else {
            $sales = $sales
                ->where("status_id", "!=", 2)
                ->where("user_id", $user->user_id)
                ->orderBy("sale_id", "desc")
                ->get();

            $customers = Customer::with(
                "user:users.*"
            )->where("user_id", $user->user_id)->get();
        }

        return view(
            'pages.dashboard.sales',
            compact(
                "customers",
                "payments",
                "stocks",
                "sales"
            )
        );
    }

    public function history()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

        $sales = Sale::with([
            "user:user_id,user_name",
            "customer:customer_id,customer_name",
            "status:status_id,status_description",
            "payment:payment_id,payment_description",
        ]);

        if (in_array($user->role_id, [1, 2, 4, 5, 6])) {
            $sales = $sales
                ->where("status_id", 2)
                ->get();
        } else {
            $sales = $sales
                ->where("status_id", 2)
                ->where("user_id", $user->user_id)
                ->get();
        }

        return view(
            'pages.dashboard.histories.sale',
            compact(
                'sales',
                "user"
            )
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

            $sales = Sale::with(
                "user:users.*",
                "status:statuses.*",
                "stock:stocks.*",
                "payment:payments.*",
            )
                ->where("status_id", 2);
            if ($start == null && $end == null) {

                $sales = $sales->orderBy("sale_id", "desc")
                    ->get();
            } else {
                $sales = $sales->whereBetween("created_at", [$start, $end])
                    ->get();
            }

            if ($sales->count() == 0) {
                return back()->with('sale.error', 'Data penjualan tidak ditemukan.');
            }

            if ($format == 1) {
                return Excel::download(new SaleExport, 'sales.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.sale', compact('sales'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Penjualan.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with("sale.error", $th->getMessage());
        }
    }

    public function store()
    {
        try {

            request()->validate([
                'customer_id' => 'required',
                'stock_id' => 'required',
                "payment_id" => "required",
                "sale_quantity" => "required|numeric",
                "sale_price" => "required|numeric",
                "sale_date" => "required",
                "sale_invoice" => "image|mimes:jpeg,png,jpg|max:512",
                "sale_status" => "required",
            ]);
            $user = session()->get('user');
            $dateTime = date_format(date_create(request("sale_date")), "Y-m-d H:i:s");

            if (request()->hasFile('sale_invoice')) {
                $file = request()->file('sale_invoice');
                $fileName = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/invoices', $fileName);

                Sale::create([
                    "customer_id" => (int) request("customer_id"),
                    "stock_id" => (int) request("stock_id"),
                    "payment_id" => (int) request("payment_id"),
                    "status_id" => (int) request("sale_status"),
                    "user_id" => (int) $user->user_id,
                    "sale_quantity" => (int) request("sale_quantity"),
                    "sale_price" => (int) request("sale_price"),
                    "sale_total" => (int) request("sale_total"),
                    "sale_description" => request("sale_description"),
                    "sale_invoice" => $fileName,
                    "sale_date" => $dateTime,
                ]);
            } else {
                Sale::create([
                    "customer_id" => (int) request("customer_id"),
                    "stock_id" => (int) request("stock_id"),
                    "payment_id" => (int) request("payment_id"),
                    "status_id" => (int) request("sale_status"),
                    "user_id" => (int) $user->user_id,
                    "sale_quantity" => (int) request("sale_quantity"),
                    "sale_price" => (int) request("sale_price"),
                    "sale_total" => (int) request("sale_total"),
                    "sale_description" => request("sale_description"),
                    "sale_date" => $dateTime,
                ]);
            }

            return back()->with('sales.success', 'Sales created successfully');
        } catch (\Throwable $th) {
            return back()->with('sale.error', $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            request()->validate([
                'customer_id' => 'required',
                'stock_id' => 'required',
                "payment_id" => "required",
                "sale_quantity" => "required|numeric",
                "sale_price" => "required|numeric",
                "sale_date" => "required",
                "sale_invoice" => "image|mimes:jpeg,png,jpg|max:512",
                "sale_status" => "required",
            ]);
            $sale = Sale::where("sale_id", $id);
            $total = (int) request("sale_quantity") * (int) request("sale_price");

            if (request()->hasFile('sale_invoice')) {
                $old = Sale::where("sale_id", $id)->first();
                if (file_exists('storage/invoices/' . $old->sale_invoice) && $old->sale_invoice != null) {
                    unlink('storage/invoices/' . $old->sale_invoice);
                }

                $file = request()->file('sale_invoice');
                $fileName = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/invoices', $fileName);

                $sale->update([
                    "customer_id" => (int) request("customer_id"),
                    "stock_id" => (int) request("stock_id"),
                    "payment_id" => (int) request("payment_id"),
                    "status_id" => (int) request("sale_status"),
                    "sale_quantity" => (int) request("sale_quantity"),
                    "sale_price" => (int) request("sale_price"),
                    "sale_total" => $total,
                    "sale_description" => request("sale_description"),
                    "sale_invoice" => $fileName,
                    "sale_date" => request("sale_date"),
                ]);
            } else {
                $sale->update([
                    "customer_id" => (int) request("customer_id"),
                    "stock_id" => (int) request("stock_id"),
                    "payment_id" => (int) request("payment_id"),
                    "status_id" => (int) request("sale_status"),
                    "sale_quantity" => (int) request("sale_quantity"),
                    "sale_price" => (int) request("sale_price"),
                    "sale_total" => $total,
                    "sale_description" => request("sale_description"),
                    "sale_date" => request("sale_date"),
                ]);
            }

            return back()->with('sales.success', 'Sales updated successfully');
        } catch (\Throwable $th) {
            return back()->with('sale.error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sale = Sale::where("sale_id", $id)->first();
            if (file_exists('storage/invoices/' . $sale->sale_invoice)) {
                unlink('storage/invoices/' . $sale->sale_invoice);
            }
            Sale::where("sale_id", $id)->delete();
            return response()->json([
                "status" => true,
                "message" => "Sales deleted successfully",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function submit($id)
    {
        try {
            Sale::where("sale_id", $id)->update([
                "status_id" => 1,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Sales submitted successfully",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function approve($id)
    {
        try {
            $user = session()->get("user");
            if (in_array($user->role_id, [1, 2])) {
                $sale = Sale::where("sale_id", $id);

                $stock = Stock::where("stock_id", $sale->first()->stock_id);

                if ($stock->first()->stock_quantity == 0) {
                    return response()->json([
                        "status" => false,
                        "message" => "Stock is empty",
                    ])->setStatusCode(400);
                } else {
                    $stock->decrement("stock_quantity", $sale->first()->sale_quantity);
                }

                $finance = Finance::create([
                    "finance_code" => "S-" . rand(1, 99999999),
                    "finance_name" => "Penjualan " . $sale->first()->sale_description,
                    "finance_debet" => $sale->first()->sale_total,
                    "finance_credit" => 0,
                    "finance_description" => "Penjualan " . $sale->first()->sale_description,
                ]);

                $shipment = Shipment::create([
                    "sale_id" => $sale->first()->sale_id,
                    "shipment_status" => "PENDING",
                ]);

                $sale->update([
                    "status_id" => 2,
                    "finance_id" => $finance->finance_id,
                ]);

                return response()->json([
                    "status" => true,
                    "message" => "Sales approved successfully",
                    "finance" => $finance,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses untuk menyetujui data penjualan.",
                    "user" => $user,
                ])->setStatusCode(403);
            }

        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function reject($id)
    {
        try {
            $user = session()->get("user");
            if (in_array($user->role_id, [1, 2])) {
                $sale = Sale::where("sale_id", $id);

                $sale->update([
                    "status_id" => 5,
                    "sale_reject_message" => request("purchase_reject_message"),
                ]);

                return response()->json([
                    "status" => true,
                    "message" => "Sales rejected successfully",
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses untuk menolak data penjualan.",
                    "user" => $user,
                ])->setStatusCode(403);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }
}
