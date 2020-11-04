<?php

namespace App\Http\Middleware;
use Config;
use Closure;
use DB;

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
        //get url  as sub_domain
        $url = \URL::current();
        $host_name = $_SERVER['HTTP_HOST'];
        $url .= " HOST: " . $host_name;

        //get db name 
        
        $tenant = DB::table('tenants as t')
        ->where('t.slug',$url)
        ->select('t.slug','t.db_name')
        ->first();
         $subdomain = $tenant->slug;
         $dbname = $tenant->db_name;
      
        // Connect to the tenant database
        Config::set('database.connections.mysql.database', 'mts_'.$dbname);
        Config::set('database.default', 'mysql');
        DB::reconnect('mysql');
        // Store the credentials into the session
        return $next($request);
    }
}
