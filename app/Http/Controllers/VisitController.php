<?php

namespace App\Http\Controllers;

use App\Exports\VisitExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Visit;
use Maatwebsite\Excel\Facades\Excel;

class VisitController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [4])) {
            return redirect()->route('dashboard');
        }

        $customers = [];
        $visits = Visit::with(
            "customer:customers.*",
            "user:users.*"
        );

        if (in_array($user->role_id, [1, 2, 5, 6])) {
            $visits = $visits->get();

            $customers = Customer::
                with(
                "user:users.*"
            )->get();

        } else {
            $visits = $visits->where('user_id', $user->user_id)->get();

            $customers = Customer::with(
                "user:users.*"
            )->
                where('user_id', $user->user_id)->get();
        }

        return view(
            'pages.dashboard.visit',
            compact(
                "customers",
                "visits",
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
            $user = session()->get('user');
            $start = request("start_date");
            $end = request("end_date");

            $visits = Visit::with(
                "customer:customers.*",
                "user:users.*"
            );

            if (in_array($user->role_id, [3])) {
                $visits = $visits->where('user_id', $user->user_id);
            }

            if ($start == null && $end == null) {
                $visits = $visits->get();
            } else {
                $visits = $visits->whereBetween("created_at", [$start, $end])->get();
            }

            if ($visits->count() == 0) {
                return back()->with("visit.error", "Data not found");
            }

            if ($format == 1) {
                return Excel::download(new VisitExport($start, $end), "visit-" . date("Y-m-d") . ".xlsx");
            } else {
                $pdf = \PDF::loadView("pages.exports.visit", compact("visits"))
                    ->setPaper('a4', 'landscape');
                return $pdf->download("visit-" . date("Y-m-d") . ".pdf");
            }

        } catch (\Throwable $th) {
            return back()->with("visit.error", $th->getMessage());
        }
    }

    public function store()
    {
        try {
            request()->validate([
                "customer_id" => "required",
                "visit_description" => "required",
                "visit_photo" => "required|mimes:jpg,jpeg,png|max:512",
            ]);

            $user = session()->get('user');

            $file = request()->visit_photo;
            $fname = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move('storage/visits', $fname);

            Visit::create([
                "customer_id" => (int) request()->customer_id,
                "user_id" => (int) $user->user_id,
                "visit_description" => request()->visit_description,
                "visit_photo" => $fname,
            ]);

            return back()->with("visit.success", "Visit created successfully");
        } catch (\Throwable $th) {
            return back()->with("visit.error", $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            request()->validate([
                "customer_id" => "required",
                "visit_description" => "required",
                "visit_photo" => "mimes:jpg,jpeg,png|max:512",
            ]);

            if (request()->hasFile('visit_photo')) {
                $old = Visit::where("visit_id", $id)->first();
                if (file_exists(public_path('storage/visits/' . $old->visit_photo))) {
                    unlink(public_path('storage/visits/' . $old->visit_photo));
                }

                $file = request()->visit_photo;
                $fname = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/visits', $fname);

                Visit::where("visit_id", $id)->update([
                    "customer_id" => (int) request()->customer_id,
                    "visit_description" => request()->visit_description,
                    "visit_photo" => $fname,
                ]);
            } else {
                Visit::where("visit_id", $id)->update([
                    "customer_id" => (int) request()->customer_id,
                    "visit_description" => request()->visit_description,
                ]);
            }

            return back()->with("visit.success", "Visit updated successfully");
        } catch (\Throwable $th) {
            return back()->with("visit.error", $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $old = Visit::where("visit_id", $id)->first();
            if (file_exists(public_path('storage/visits/' . $old->visit_photo))) {
                unlink(public_path('storage/visits/' . $old->visit_photo));
            }

            Visit::where("visit_id", $id)->delete();

            return response()->json([
                "status" => true,
                "message" => "Visit deleted successfully",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }
}
