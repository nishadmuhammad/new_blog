<?php

namespace App\Http\Middleware;

use Closure;

class Tenancy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    // {
    //     // echo"hello testing now";
    //  //   Check if its first time visit enable shared session
    //     if ($request->has('session_token')) {
    //         $user = Auth::user();
    //         Session::setId($request->get('session_token'));
    //         Session::start();
    //     }
    //     // Check if session doesn't exist
    //     elseif (count(Session::all()) == 0) {

    //         return redirect()->route('master.logout', ['accounts']);
    //     }
    //     // Get the subdomain and modify the database on the fly
    //     $route = $request->route();
    //     $subdomain = $route->parameter('subdomain');
    //     // Check if session has config already exist
    //     if ($request->session()->has($subdomain)) {
    //         $tenant = $request->session()->get($subdomain);
    //     } else {
    //         // Retrieve requested tenant's info from database. If not found, abort the request.
    //         $tenant = Tenant::where('slug', $subdomain)->firstOrFail();
    //     }
    //     // Connect to the tenant database
    //     Config::set('database.connections.mysql.database', 'mts_'.$subdomain);
    //     Config::set('database.default', 'mysql');
    //     DB::reconnect('mysql');
    //     // Store the credentials into the session
    //     $request->session()->put('tenant', $tenant);
    //     $request->session()->put($subdomain, $tenant);
    //     $request->session()->put('subdomain', $subdomain);
    //     $request->session()->put('auth_users', Candidate::all_user());
    //     $response = $next($request);
    //     $user = GlobalAuth::user();
    //     if ($user) {
    //         $response->headers->set('X-Username', $user->email);
    //     } else {
    //         $response->headers->set('X-Username', 'Anonymous');
    //     }

    // }


     /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
//   public function handle($request, Closure $next)
  {

    $url = \URL::current();
    $host_name = $_SERVER['HTTP_HOST'];

    $url .= " HOST: " . $host_name;

    $masterDatabase = 'mapletechspace_';

    try {
      $length = 0;
      $newDB = "";

      DB::disconnect('mysql');
      //here connection name, I used mysql for example
      Config::set('database.connections.mysql.database', $masterDatabase); //new database name, you want to connect to.

      // $dbDetails = DB::table('master')
      //   ->where('status', '1')
      //   ->where('embase_url', $host_name)
      //   ->select('institute_no', 'institution_nick', 'embase_url', 'dbHost', 'dbName', 'dbUser', 'dbPass', 'port', 'status')
      //   ->get();
      // migration start
      
      //
    //   for get databse details of user
      $dbDetails = DB::table('test_table') 
      ->get();
      
      
      // migration end

      DB::disconnect('mysql'); //here connection name, I used mysql for example

      $length = count($dbDetails);


      if ($length > 0) {
        $newDB = $dbDetails[0]->dbName;
        $newUN = $dbDetails[0]->dbUser;
        $newPSWD = $dbDetails[0]->dbPass;

        DB::disconnect('mysql'); //here connection name, I used mysql for example
        Config::set('database.connections.mysql.database', $newDB); //new database name, you want to connect to.
        Config::set('database.connections.mysql.username', $newUN); //new database name, you want to connect to.
        Config::set('database.connections.mysql.password', $newPSWD); //new database name, you want to connect to.

        /*DB::reconnect('mysql2');
              DB::setDefaultConnection('mysql2');*/

        DB::reconnect('mysql');
        DB::setDefaultConnection('mysql');
      } else {
        $institute = '';
      }
    } catch (Exception $e) {
      $log = $e;
    }

    return $next($request);
  }

}
