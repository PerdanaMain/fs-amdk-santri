<?php

namespace App\Http\Controllers;

use App\Exports\AssetExport;
use App\Models\Asset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::orderBy('created_at', 'desc')->get();
        $totalAssetValue = $assets->sum('current_value');
        
        return view('pages.dashboard.asset', compact('assets', 'totalAssetValue'));
    }

    public function export(Request $request)
    {
        if ($request->format == 1) {
            return Excel::download(new AssetExport, 'Data-Asset.xlsx');
        }

        $assets = Asset::all();
        $pdf = Pdf::loadView('pages.exports.asset', compact('assets'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('Data-Asset.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_name' => 'required|string',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric',
            'lifetime_years' => 'required|integer|min:1',
            'asset_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('asset_photo')) {
            $file = $request->file('asset_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assets', $filename);
            $photoPath = $filename;
        }

        $lifetimeYears = (int) $request->lifetime_years;

        // Calculate depreciation per month
        // Rumus: Harga Beli / (Tahun * 12)
        $depreciationPerMonth = $request->purchase_price / ($lifetimeYears * 12);
        
        // Generate Asset Code: AST-YYYYMMDD-HIS
        $assetCode = 'AST-' . date('Ymd-His');

        Asset::create([
            'asset_code' => $assetCode,
            'asset_name' => $request->asset_name,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'lifetime_years' => $lifetimeYears,
            'asset_photo' => $photoPath,
            'depreciation_per_month' => $depreciationPerMonth
        ]);

        return redirect()->back()->with('success', 'Asset created successfully');
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        
        $request->validate([
            'asset_name' => 'required|string',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric',
            'lifetime_years' => 'required|integer|min:1',
            'asset_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $lifetimeYears = (int) $request->lifetime_years;

        $data = [
            'asset_name' => $request->asset_name,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'lifetime_years' => $lifetimeYears,
        ];

        // Recalculate depreciation if price or lifetime changes
        $data['depreciation_per_month'] = $request->purchase_price / ($lifetimeYears * 12);

        if ($request->hasFile('asset_photo')) {
            // Delete old photo
            if ($asset->asset_photo) {
                Storage::delete('public/assets/' . $asset->asset_photo);
            }
            
            $file = $request->file('asset_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assets', $filename);
            $data['asset_photo'] = $filename;
        }

        $asset->update($data);

        return redirect()->back()->with('success', 'Asset updated successfully');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        if ($asset->asset_photo) {
            Storage::delete('public/assets/' . $asset->asset_photo);
        }
        $asset->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Asset deleted successfully'
        ]);
    }
}
