<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
	'namespace' => 'Api',
	'middleware' => 'auth:api',
	// 'middleware' => 'api',
	// 'prefix' => 'paper'
], function () {




});

Route::group([
	// 'namespace' => 'Api',
	// 'middleware' => ['api', 'tenancy'],
	'prefix' => 'task'
], function () {
	// Route::post('add-task', 'ContactController@addTask');
	Route::post('edit-task', 'ContactController@editTask');

});
Route::post('add-task', 'ContactController@addTask');

