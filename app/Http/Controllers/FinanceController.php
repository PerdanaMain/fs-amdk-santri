<?php

namespace App\Http\Controllers;

use App\Exports\FinanceExport;
use App\Http\Controllers\Controller;
use App\Models\Finance;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3, 4])) {
            return redirect()->route('dashboard');
        }

        $finances = Finance::with([
            "purchase:purchases.*",
            "sale:sales.*",
            "sale.customer:customers.*",
        ])
            ->orderBy("finance_id", "desc")
            ->get();

        $totalDebet = $finances->sum("finance_debet");
        $totalCredit = $finances->sum("finance_credit");

        return view(
            "pages.dashboard.finance",
            compact(
                "finances",
                "totalDebet",
                "totalCredit"
            )
        );
    }

    public function store()
    {
        try {
            //validate
            request()->validate([
                "finance_name" => "required",
                "finance_credit" => "required|numeric",
                "finance_description" => "required",
            ]);

            Finance::create([
                "finance_code" => "O-" . rand(1, 99999999),
                "finance_name" => request("finance_name"),
                "finance_credit" => request("finance_credit"),
                "finance_debet" => 0,
                "finance_description" => request("finance_description"),
            ]);

            return back()->with("finance.success", "Data keuangan berhasil ditambahkan.");
        } catch (\Throwable $th) {
            return back()->with('finance.error', $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            //validate
            request()->validate([
                "finance_name" => "required",
                "finance_credit" => "required|numeric",
                "finance_description" => "required",
            ]);

            $finance = Finance::where("finance_id", $id);
            $finance->update([
                "finance_name" => request("finance_name"),
                "finance_credit" => request("finance_credit"),
                "finance_debet" => 0,
                "finance_description" => request("finance_description"),
            ]);

            return back()->with("finance.success", "Data keuangan berhasil diubah.");
        } catch (\Throwable $th) {
            return back()->with('finance.error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $finance = Finance::where("finance_id", $id);
            $finance->delete();
            return response()->json([
                "status" => true,
                "message" => "Data keuangan berhasil dihapus.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
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

            $finances = Finance::with([
                "purchase:purchases.*",
                "sale:sales.*",
            ]);

            if ($start == null && $end == null) {
                $finances->orderBy("finance_id", "desc")
                    ->get();
            } else {
                $finances = $finances->whereBetween("created_at", [$start, $end])
                    ->get();
            }

            if ($finances->count() == 0) {
                return back()->with('finance.error', 'Data keuangan tidak ditemukan.');
            }

            if ($format == 1) {
                $filename = "finance-" . date("Y-m-d") . ".xlsx";
                return Excel::download(new FinanceExport($start, $end), $filename);
            } else {
                $finances = $finances->get();
                $pdf = \PDF::loadView("pages.exports.finance", compact("finances"))
                    ->setPaper('a4', 'landscape');
                return $pdf->download("finance-" . date("Y-m-d") . ".pdf");
            }

        } catch (\Throwable $th) {
            return back()->with('finance.error', $th->getMessage());
        }
    }
}
