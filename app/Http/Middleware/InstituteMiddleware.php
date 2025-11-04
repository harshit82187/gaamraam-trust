<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstituteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // dd('Middleware executed');
        // Check if the user is authenticated and is an admin
        if (!Auth::guard('institute')->check()) {
            return redirect()->route('our-institutions')->with('error','Unautorized user!');
        }

        return $next($request);
    }
}
