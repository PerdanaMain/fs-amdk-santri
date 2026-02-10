<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Routing\Controller;

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
}
