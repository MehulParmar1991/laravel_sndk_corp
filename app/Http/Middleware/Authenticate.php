<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware {

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string {
        //return $request->expectsJson() ? null : route('login');
        $request->authenticate();

        $request->session()->regenerate();

        $url = "";
        if ($request->user()->role === "admin") {
            $url = "admin/dashboard";
        } elseif ($request->user()->role === "agent") {
            $url = "agent/dashboard";
        } else {
            $url = "dashboard";
        }

        return redirect()->intended($url);
    }
}
