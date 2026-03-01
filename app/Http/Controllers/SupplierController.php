<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function index()
    {
        $user = session()->get('user');

        if (in_array($user->role_id, [4])) {
            return redirect()->route('dashboard');
        }

        $suppliers = Supplier::orderBy("supplier_id", "desc")->get();

        return view(
            'pages.dashboard.supplier',
            compact(
                'suppliers'
            )
        );
    }

    public function store()
    {
        try {
            $this->validate(request(), [
                "supplier_name" => "required",
                "supplier_owner" => "required",
                "supplier_address" => "required",
                "supplier_phone" => "required",
                "supplier_photo" => "image|mimes:jpeg,png,jpg|max:512",
            ]);

            $data = [
                "supplier_name" => request("supplier_name"),
                "supplier_owner" => request("supplier_owner"),
                "supplier_address" => request("supplier_address"),
                "supplier_phone" => request("supplier_phone"),
                "supplier_coordinate" => request("supplier_coordinate"),
                "supplier_description" => request("supplier_description"),
            ];

            if (request()->hasFile('supplier_photo')) {
                $file = request()->file('supplier_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/suppliers', $file_name);
                $data["supplier_photo"] = $file_name;
            }

            Supplier::create($data);

            return back()->with('supplier.success', 'Supplier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('supplier.error', 'Supplier gagal ditambahkan: ' . $th->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $this->validate(request(), [
                "supplier_name" => "required",
                "supplier_owner" => "required",
                "supplier_address" => "required",
                "supplier_phone" => "required",
                "supplier_photo" => "nullable|image|mimes:jpeg,png,jpg|max:512",
            ]);

            $supplier = Supplier::where("supplier_id", $id)->firstOrFail();

            $data = [
                "supplier_name" => request("supplier_name"),
                "supplier_owner" => request("supplier_owner"),
                "supplier_address" => request("supplier_address"),
                "supplier_phone" => request("supplier_phone"),
                "supplier_coordinate" => request("supplier_coordinate"),
                "supplier_description" => request("supplier_description"),
            ];

            if (request()->hasFile('supplier_photo')) {
                if ($supplier->supplier_photo && file_exists(public_path('storage/suppliers/' . $supplier->supplier_photo))) {
                    unlink(public_path('storage/suppliers/' . $supplier->supplier_photo));
                }

                $file = request()->file('supplier_photo');
                $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move('storage/suppliers', $file_name);
                $data["supplier_photo"] = $file_name;
            }

            $supplier->update($data);

            return back()->with('supplier.success', 'Supplier berhasil diubah.');

        } catch (\Throwable $th) {
            return back()->with('supplier.error', 'Supplier gagal diubah: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::where("supplier_id", $id)->firstOrFail();
            
            if ($supplier->supplier_photo != null) {
                if (file_exists(public_path('storage/suppliers/' . $supplier->supplier_photo))) {
                    unlink(public_path('storage/suppliers/' . $supplier->supplier_photo));
                }
            }
            $supplier->delete();

            return response()->json([
                "status" => true,
                "message" => "Supplier berhasil dihapus.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }
}
