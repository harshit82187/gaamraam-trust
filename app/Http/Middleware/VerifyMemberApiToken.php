<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        // \Log::info('VerifyApiToken: token = ' . $token);
        if (empty($token)) {
            return response()->json([
                'status' => false,
                'message' => 'Token is missing'
            ], 401);
        }
        $user = User::where('api_token', $token)->first();
        // \Log::info('User found = ' . ($user ? 'yes' : 'no'));
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401); 
        }
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}