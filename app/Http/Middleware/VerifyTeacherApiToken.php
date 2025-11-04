<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Teacher;

class VerifyTeacherApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        \Log::info('VerifyTeacherApiToken: token = ' . $token);
        if (empty($token)) {
            return response()->json([
                'status' => false,
                'message' => 'Token is missing'
            ], 401);
        }
        $teacher = Teacher::where('api_token', $token)->first();
        \Log::info('Teacher found = ' . ($teacher ? 'yes' : 'no'));
        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized or invalid token'
            ], 401); 
        }
        $request->merge(['auth_user' => $teacher]);
        return $next($request);
    }
}