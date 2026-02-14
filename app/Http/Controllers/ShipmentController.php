<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Routing\Controller;
use App\Exports\ShipmentExport;
use Maatwebsite\Excel\Facades\Excel;

class ShipmentController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3])) {
            return redirect()->route('dashboard');
        }
        $shipments = Shipment::with([
            "sale" => [
                "customer",
                "stock",
                "payment",
                "status",
                "user",
                "finance",
            ],
        ])->get();

        return view(
            'pages.dashboard.shipment',
            compact('shipments')
        );
    }

    public function history()
    {
        $user = session()->get('user');
        if (in_array($user->role_id, [3])) {
            return redirect()->route('dashboard');
        }

        $shipments = Shipment::with([
            "sale" => [
                "customer",
                "stock",
                "payment",
                "status",
                "user",
                "finance",
            ],
        ])
        ->where('shipment_status', 'DONE')
        ->get();

        return view(
            'pages.dashboard.histories.shipment',
            compact('shipments')
        );
    }

    public function delivery($id)
    {
        try {
            $shipment = Shipment::where("shipment_id", $id);
            $shipment->update([
                'shipment_status' => 'DELIVERY',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Shipment status has been updated to DELIVERY',
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function done($id)
    {
        try {
            $shipment = Shipment::where("shipment_id", $id);
            $shipment->update([
                'shipment_status' => 'DONE',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Shipment status has been updated to DONE',
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
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

            $shipments = Shipment::with([
                "sale.customer",
                "sale.stock",
                "sale.user",
            ]);

            if ($start && $end) {
                $shipments->whereBetween("created_at", [$start, $end]);
            }
            
            if (request()->route()->getName() == 'deliveryHistory.export') {
                $shipments->where('shipment_status', 'DONE');
            }

            $shipments = $shipments->get();

            if ($shipments->count() == 0) {
                return back()->with('shipment.error', 'Data pengiriman tidak ditemukan.');
            }

            if ($format == 1) {
                return Excel::download(new ShipmentExport, 'shipments.xlsx');
            } else {
                $pdf = \PDF::loadView('pages.exports.shipment', compact('shipments'))
                    ->setPaper('a4', 'landscape');
                return $pdf->download('Data-Pengiriman.pdf');
            }
        } catch (\Throwable $th) {
            return back()->with("shipment.error", $th->getMessage());
        }
    }
}
