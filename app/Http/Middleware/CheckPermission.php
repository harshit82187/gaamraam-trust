<?php 


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $permissions = session('role_permissions', []);
        $module = $request->segment(2);
        if (!in_array($module, $permissions)) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
