<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    protected function redirectTo(Request $request): ?string
    {
        $user = session()->get("user");

        if ($user) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('home');
        }
    }
}
