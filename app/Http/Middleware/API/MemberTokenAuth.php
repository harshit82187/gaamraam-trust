<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MemberTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken(); // gets token from Authorization header

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated (Token missing)',
            ], 401);
        }

        $hashedToken = hash('sha256', $token);
        $user = User::where('member_token', $hashedToken)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated (Invalid token)',
            ], 401);
        }

        // Manually set the user for later retrieval using auth()->user()
        auth()->setUser($user);

        return $next($request);
    }
}