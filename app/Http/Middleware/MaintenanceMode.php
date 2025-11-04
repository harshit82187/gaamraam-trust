<?php 


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        if (Setting::get('maintenance_mode') === 'on' && !$request->is('admin/*')) {
            return response()->view('front.maintenance.index');
        }
        return $next($request);
    }
}