<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = session()->get("user");

        if ($user) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
