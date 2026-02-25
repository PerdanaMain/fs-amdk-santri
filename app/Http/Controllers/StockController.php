<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StockExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view(
            'pages.dashboard.stock',
            compact('stocks')
        );
    }

    public function export(Request $request)
    {
        if ($request->format == 1) {
            return Excel::download(new StockExport, 'Data-Stock.xlsx');
        }

        $stocks = Stock::all();
        $pdf = Pdf::loadView('pages.exports.stock', compact('stocks'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('Data-Stock.pdf');
    }

    public function store()
    {
        // validate the request
        request()->validate([
            'stock_name' => 'required',
            'stock_quantity' => 'required|numeric',
            "stock_satuan" => "required",
            "stock_description" => "required",
            'stock_photo' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        // get file
        $file = request()->file('stock_photo');
        $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
        $file->move('storage/stocks', $file_name);

        Stock::create([
            'stock_name' => request('stock_name'),
            'stock_quantity' => request('stock_quantity'),
            'stock_satuan' => request('stock_satuan'),
            'stock_description' => request('stock_description'),
            'stock_photo' => $file_name,
        ]);
        return back()->with('stock.success', 'Stock berhasil ditambahkan.');
    }

    public function update($id)
    {
        // validate the request
        request()->validate([
            'stock_name' => 'required',
            'stock_quantity' => 'required|numeric',
            "stock_satuan" => "required",
            "stock_description" => "required",
            'stock_photo' => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $stock = Stock::where("stock_id", $id);

        if (request()->hasFile('stock_photo')) {
            // unlink old file
            $old = Stock::where("stock_id", $id)->first();
            unlink(public_path('storage/stocks/' . $old->stock_photo));

            $file = request()->file('stock_photo');
            $file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move('storage/stocks', $file_name);

            // update the stock
            $stock->update([
                'stock_name' => request('stock_name'),
                'stock_quantity' => request('stock_quantity'),
                'stock_satuan' => request('stock_satuan'),
                'stock_description' => request('stock_description'),
                'stock_photo' => $file_name,
            ]);
        } else {
            $stock->update([
                'stock_name' => request('stock_name'),
                'stock_quantity' => request('stock_quantity'),
                'stock_satuan' => request('stock_satuan'),
                'stock_description' => request('stock_description'),
            ]);
        }

        return back()->with('stock.success', 'Stock berhasil diupdate.');
    }

    public function destroy($id)
    {
        try {

            // unlink the file
            $stock = Stock::where("stock_id", $id)->first();
            unlink(public_path('storage/stocks/' . $stock->stock_photo));

            Stock::where("stock_id", $id)->delete();

            return response()->json([
                "status" => true,
                "message" => "Stock berhasil dihapus.",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Stock gagal dihapus.",
            ])->setStatusCode(500);
        }
    }
}