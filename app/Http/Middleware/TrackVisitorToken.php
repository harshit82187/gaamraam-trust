<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VisitorToken;

class TrackVisitorToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('visitor_token')) {
            $token = Str::uuid()->toString();
            $ip = $request->ip();

            VisitorToken::create([
                'token' => $token,
                'ip' => $ip,
            ]);

            $request->session()->put('visitor_token', $token);
        }

        return $next($request);
    }
}
