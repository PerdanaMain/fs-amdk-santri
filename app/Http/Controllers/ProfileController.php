<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $session = session()->get('user');

        $user = User::where('user_id', $session->user_id)->first();

        return view(
            'pages.dashboard.profile',
            compact('user')
        );
    }

    public function update($id)
    {
        // validate request
        $this->validate(request(), [
            "user_nip" => "numeric",
            "user_nik" => "required|numeric",
            'user_name' => 'required',
            'user_phone' => 'required',
            'user_address' => 'required',
            "user_photo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "user_password" => "nullable|min:8",
        ]);

        $user_password_confirmation = request("user_conf_password");
        if (request("user_password") !== $user_password_confirmation) {
            return back()->with('profile.error', 'Password confirmation does not match');
        }

        // get user
        $user = User::where("user_id", $id);

        // update user
        if (request()->hasFile('user_photo')) {
            $old = User::where("user_id", $id)->first();

            if ($old->user_photo != null) {
                if (file_exists(public_path('storage/profiles/' . $old->user_photo))) {
                    unlink(public_path('storage/profiles/' . $old->user_photo));
                }
            }

            $user_photo = request()->file('user_photo');
            $user_photo_name = md5($user_photo->getClientOriginalName() . time()) . '.' . $user_photo->getClientOriginalExtension();
            $user_photo->move('storage/profiles', $user_photo_name);

            $user->update([
                "user_photo" => $user_photo_name,
                "user_nip" => request('user_nip'),
                "user_nik" => request('user_nik'),
                "user_name" => request('user_name'),
                "user_phone" => request('user_phone'),
                "user_address" => request('user_address'),
                "password" => bcrypt(request('user_password')),
            ]);
        } else {
            $user->update([
                "user_nip" => request('user_nip'),
                "user_nik" => request('user_nik'),
                "user_name" => request('user_name'),
                "user_phone" => request('user_phone'),
                "user_address" => request('user_address'),
                "password" => bcrypt(request('user_password')),
            ]);
        }

        // update the session
        $user = User::where('user_id', $id)->first();
        session()->put('user', $user);

        return back()->with('profile.success', 'Profile updated successfully');

    }
}
