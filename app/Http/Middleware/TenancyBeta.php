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
        if ($request->has('session_token')) {
            $user = Auth::user();
            Session::setId($request->get('session_token'));
            Session::start();
        }
        // Check if session doesn't exist
        elseif (count(Session::all()) == 0) {

            return redirect()->route('master.logout', ['accounts']);
        }
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
        $request->session()->put('tenant', $tenant);
        $request->session()->put($subdomain, $tenant);
        $request->session()->put('subdomain', $subdomain);
        $request->session()->put('auth_users', Candidate::all_user());
        $response = $next($request);
        $user = GlobalAuth::user();
        if ($user) {
            $response->headers->set('X-Username', $user->email);
        } else {
            $response->headers->set('X-Username', 'Anonymous');
        }
        // return $next($request);
    }
}
