<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $user = session()->get('user');

        if (in_array($user->role_id, [4])) {
            return redirect()->route('dashboard');
        }

        $customers = Customer::with([
            "user:user_id,user_name",
            "sales" => function ($query) {
                $query->where("status_id", 2);
            },
        ]);
        $ptg = [];

        if (in_array($user->role_id, [1, 2, 4, 5, 6])) {
            $customers = $customers->orderBy("customer_id", "desc")
                ->get();

            $ptg = User::where('role_id', 3)->get();
        } else {
            $customers = $customers->where("user_id", $user->user_id)
                ->orderBy("customer_id", "desc")
                ->get();

            $ptg = User::where("user_id", $user->user_id)->get();
        }

        return view(
            'pages.dashboard.customer',
            compact(
                'customers',
                "ptg"
            )
        );
    }

    public function store()
    {
        try {
            $this->validate(request(), [
                'user_id' => 'required',
                "customer_name" => "required",
                "customer_owner" => "required",
                "customer_address" => "required",
                "customer_phone" => "required",
                "customer_photo" => "image|mimes:jpeg,png,jpg|max:512",
            ]);

            if (request()->hasFile('customer_photo')) {
                $file = request()->file('customer_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/customers', $file_name);

                Customer::create([
                    'user_id' => (int) request('user_id'),
                    "customer_name" => request("customer_name"),
                    "customer_owner" => request("customer_owner"),
                    "customer_address" => request("customer_address"),
                    "customer_phone" => request("customer_phone"),
                    "customer_coordinate" => request("customer_coordinate"),
                    "customer_photo" => $file_name,
                ]);

            } else {
                Customer::create([
                    'user_id' => (int) request('user_id'),
                    "customer_name" => request("customer_name"),
                    "customer_owner" => request("customer_owner"),
                    "customer_address" => request("customer_address"),
                    "customer_coordinate" => request("customer_coordinate"),
                    "customer_phone" => request("customer_phone"),
                ]);
            }

            return back()->with('customer.success', 'Customer berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('customer.error', 'Customer gagal ditambahkan.');
        }
    }

    public function import()
    {
        try {
            $this->validate(request(), [
                'customer_file' => 'required|mimes:xlsx,xls',
            ]);

            $customers = Excel::import(new CustomerImport, request()->file('customer_file'));

            return back()->with('customer.success', 'Customer berhasil diimport.');
        } catch (\Throwable $th) {
            return back()->with('customer.error', $th->getMessage());
        }
    }

    public function export()
    {
        try {
            request()->validate([
                'user_id' => 'required',
                'format' => 'required',
            ]);

            $format = (int) request('format');

            $customers = Customer::all();
            if ($customers->isEmpty()) {
                return back()->with('customer.error', 'Data customer kosong.');
            }

            if ($format == 1) {
                return Excel::download(new CustomerExport((int) request("user_id")), 'Customer-Data.xlsx');
            } else {
                $user = (int) request('user_id');
                $customers = Customer::with([
                    "user:user_id,user_name",
                    "sales" => function ($query) {
                        $query->where("status_id", 2);
                    },
                ])
                    ->orderBy("customer_id", "desc");
                if ($user != 0) {
                    $customers = $customers
                        ->where("user_id", (int) request("user_id"))
                        ->get();
                } else {
                    $customers = $customers
                        ->get();
                }

                $pdf = pdf::loadView('pages.exports.customer', compact('customers'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Customer-Data.pdf');
            }

        } catch (\Throwable $th) {
            return back()->with('customer.error', $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $user = session()->get('user');
            if (!$user->role_id == 2) {
                return back()->with('customer.error', 'Anda tidak memiliki akses.');
            }

            $this->validate(request(), [
                'user_id' => 'required',
                "customer_name" => "required",
                "customer_owner" => "required",
                "customer_address" => "required",
                "customer_phone" => "required",
                "customer_photo" => "nullable|image|mimes:jpeg,png,jpg|max:512",
            ]);

            $customer = Customer::where("customer_id", $id);

            if (request()->hasFile('customer_photo')) {
                $old = Customer::where("customer_id", $id)->first();
                unlink(public_path('storage/customers/' . $old->customer_photo));

                $file = request()->file('customer_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/customers', $file_name);

                $customer->update([
                    'user_id' => (int) request('user_id'),
                    "customer_name" => request("customer_name"),
                    "customer_owner" => request("customer_owner"),
                    "customer_address" => request("customer_address"),
                    "customer_phone" => request("customer_phone"),
                    "customer_photo" => $file_name,
                ]);

                return back()->with('customer.success', 'Customer berhasil diubah.');
            } else {
                $customer->update([
                    'user_id' => (int) request('user_id'),
                    "customer_name" => request("customer_name"),
                    "customer_owner" => request("customer_owner"),
                    "customer_address" => request("customer_address"),
                    "customer_phone" => request("customer_phone"),
                ]);

                return back()->with('customer.success', 'Customer berhasil diubah.');
            }
        } catch (\Throwable $th) {
            return back()->with('customer.error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = session()->get('user');
            if (!$user->role_id == 2) {
                return response()->json([
                    "status" => false,
                    "message" => "Anda tidak memiliki akses.",
                ])->setStatusCode(403);
            }

            $customer = Customer::where("customer_id", $id)->first();
            if ($customer->customer_photo != null) {
                if (file_exists(public_path('storage/customers/' . $customer->customer_photo))) {
                    unlink(public_path('storage/customers/' . $customer->customer_photo));
                }
            }
            Customer::where("customer_id", $id)->delete();

            return response()->json([
                "status" => true,
                "message" => "Customer berhasil dihapus.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function template()
    {
        $template = Storage::disk('public')->path('template/Customer-Template.xlsx');
        return response()->download($template);
    }
}