<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_email' => ['required', 'email'],
            'user_password' => ['required'],
        ]);

        $user = User::with("role:role_id,role_description")
            ->where('email', $credentials['user_email'])->first();

        if (!in_array($user->status, ["active", "magang"])) {
            return back()->with('auth.error', 'Anda sudah tidak memiliki akses.');
        }

        if (!$user || !Hash::check($credentials['user_password'], $user->password)) {
            return back()->with('auth.error', 'Email atau password salah.');
        }

        if (
            Auth::attempt([
                'email' => $credentials['user_email'],
                'password' => $credentials['user_password'],

            ])

        ) {
            $login = Auth::login($user);
            $request->session()->put('user', $user);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            return back()->with('auth.error', 'Email atau password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/')->with('auth.success', 'Berhasil logout.');
    }

    public function feedbackIndex()
    {
        $feedbacks = Feedback::all();

        return view(
            'pages.dashboard.feedback',
            compact('feedbacks')
        );
    }

    public function feedback()
    {
        try {

            Feedback::create([
                "feedback_firstname" => request("firstname"),
                "feedback_lastname" => request("lastname"),
                "feedback_email" => request("email"),
                "feedback_message" => request("message"),
                "feedback_phone" => request("phone"),
            ]);

            return back()->with('auth.success', 'Berhasil mengirim feedback.');
        } catch (\Throwable $th) {
            return back()->with('auth.error', $th->getMessage());
        }
    }

    public function feedbackDestroy($id)
    {
        try {
            Feedback::destroy($id);
            return response()->json([
                "message" => "Berhasil menghapus feedback.",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
