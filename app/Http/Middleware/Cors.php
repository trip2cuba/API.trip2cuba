<?php
namespace ApiTripCuba\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {

        return $next($request)
         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
         ->header('Access-Control-Max-Age', '1000')
         ->header('Access-Control-Allow-Headers', 'X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description,application/json,text/javascript');
    }
}