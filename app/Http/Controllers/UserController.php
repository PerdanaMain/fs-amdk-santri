<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where("is_forgot", true)->get();

        return view(
            'pages.dashboard.user',
            compact(
                "users"
            )
        );
    }

    public function resetSubmission($email)
    {
        try {
            $user = User::where("email", $email)->first();
            $user->is_forgot = true;
            $user->save();

            return response()->json([
                "message" => "Pengajuan reset password berhasil, mohon menunggu konfirmasi Admin",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
        }

    }

    public function resetPassword($id)
    {
        try {
            $user = User::find($id);
            $user->password = Hash::make("12345");
            $user->is_forgot = false;
            $user->save();

            return response()->json([
                "message" => "Password berhasil direset",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
        }

    }

}