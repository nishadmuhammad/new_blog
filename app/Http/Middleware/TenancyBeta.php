<?php

namespace App\Http\Middleware;

use Closure;

class TenancyBeta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
             // echo"hello testing now";
     //   Check if its first time visit enable shared session
    
        // Get the subdomain and modify the database on the fly
        $route = $request->route();
        $subdomain = $route->parameter('subdomain');
        // Check if session has config already exist
        if ($request->session()->has($subdomain)) {
            $tenant = $request->session()->get($subdomain);
        } else {
            // Retrieve requested tenant's info from database. If not found, abort the request.
            $tenant = Tenant::where('slug', $subdomain)->firstOrFail();
        }
        // Connect to the tenant database
        Config::set('database.connections.mysql.database', 'mts_'.$subdomain);
        Config::set('database.default', 'mysql');
        DB::reconnect('mysql');
        // Store the credentials into the session
        return $next($request);
    }
}
