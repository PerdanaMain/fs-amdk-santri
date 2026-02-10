<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\Role;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(
            [
                "role:roles.*",
                "customers:customers.*",
            ]
        )
            ->where("role_id", "!=", 2)
            ->orderBy("user_id", "desc")
            ->get();
        $roles = Role::where("role_id", "!=", 2)->get();
        return view(
            'pages.dashboard.employee',
            compact(
                "employees",
                "roles"
            )
        );
    }

    public function store()
    {
        try {
            // validate
            request()->validate([
                'user_name' => 'required',
                'user_nickname' => 'required',
                "user_phone" => "required|numeric",
                "user_address" => "required",
                "user_photo" => "image|mimes:jpeg,png,jpg|max:512",
                "user_branch" => "required",
                "role_id" => "required",
                "status" => "required",
            ]);

            $email = strtolower(request("user_nickname")) . "@amdksantri.com";
            $password = bcrypt("12345");

            $emailCheck = User::where("email", $email)->first();
            if ($emailCheck) {
                return back()->with('employee.error', 'Email sudah digunakan.');
            }

            if (request()->hasFile('user_photo')) {
                $file = request()->file('user_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move("storage/profiles", $file_name);

                User::create([
                    "role_id" => (int) request("role_id"),
                    "user_name" => request("user_name"),
                    "email" => $email,
                    "password" => $password,
                    "user_phone" => request("user_phone"),
                    "user_address" => request("user_address"),
                    "user_description" => request("user_description"),
                    "user_branch" => request("user_branch"),
                    "user_nik" => request("user_nik"),
                    "user_nip" => request("user_nip"),
                    "user_photo" => $file_name,
                    "status" => request("status"),
                ]);
            } else {
                User::create([
                    "role_id" => (int) request("role_id"),
                    "user_name" => request("user_name"),
                    "email" => request("user_nickname") . "@amdksantri.com",
                    "password" => $password,
                    "user_phone" => request("user_phone"),
                    "user_address" => request("user_address"),
                    "user_description" => request("user_description"),
                    "user_branch" => request("user_branch"),
                    "user_nik" => request("user_nik"),
                    "user_nip" => request("user_nip"),
                    "status" => request("status"),
                ]);
            }
            return back()->with('employee.success', 'Data karyawan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('employee.error', $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            //validate
            request()->validate([
                'user_name' => 'required',
                "user_phone" => "required|numeric",
                "user_address" => "required",
                "user_photo" => "image|mimes:jpeg,png,jpg|max:512",
                "user_branch" => "required",
                "role_id" => "required",
                "status" => "required",
            ]);

            $employee = User::where("user_id", $id);

            if (request()->hasFile('user_photo')) {
                $old = User::where("user_id", $id)->first();
                if (file_exists("storage/profiles/" . $old->user_photo)) {
                    unlink("storage/profiles/" . $old->user_photo);
                }

                $file = request()->file('user_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move("storage/profiles", $file_name);

                $employee->update([
                    "role_id" => (int) request("role_id"),
                    "user_name" => request("user_name"),
                    "user_phone" => request("user_phone"),
                    "user_address" => request("user_address"),
                    "user_description" => request("user_description"),
                    "user_branch" => request("user_branch"),
                    "user_nik" => request("user_nik"),
                    "user_nip" => request("user_nip"),
                    "user_photo" => $file_name,
                    "status" => request("status"),
                ]);
            } else {
                $employee->update([
                    "role_id" => (int) request("role_id"),
                    "user_name" => request("user_name"),
                    "user_phone" => request("user_phone"),
                    "user_address" => request("user_address"),
                    "user_description" => request("user_description"),
                    "user_branch" => request("user_branch"),
                    "user_nik" => request("user_nik"),
                    "user_nip" => request("user_nip"),
                    "status" => request("status"),
                ]);
            }

            return back()->with('employee.success', 'Data karyawan berhasil diubah.');

        } catch (\Throwable $th) {
            return back()->with('employee.error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $employee = User::where("user_id", $id)->first();
            if (file_exists("storage/profiles/" . $employee->user_photo) && $employee->user_photo != null) {
                unlink("storage/profiles/" . $employee->user_photo);
            }
            User::where("user_id", $id)->delete();

            return response()->json([
                "status" => true,
                "message" => "Data karyawan berhasil dihapus.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function export()
    {
        try {
            request()->validate([
                'format' => 'required',
            ]);

            $format = (int) request("format");
            if ($format == 1) {
                return Excel::download(new EmployeeExport, 'Employee-Data.xlsx');
            } else {
                $employees = User::with(
                    [
                        "role:roles.*",
                        "customers:customers.*",
                        "sales:sales.*",
                    ]
                )
                    ->where("role_id", "!=", 2)
                    ->where([
                        ["status", "!=", "dipecat"],
                        ["status", "!=", "resign"],
                    ])
                    ->get();

                $pdf = pdf::loadView('pages.exports.employee', compact('employees'))
                    ->setPaper("a4", "landscape");
                return $pdf->download('Employees-Data.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with('employee.error', $th->getMessage());
        }
    }
}