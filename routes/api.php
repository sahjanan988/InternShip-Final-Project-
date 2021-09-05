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

Route::post('login', 'App\Http\Controllers\AuthController@mobileAuth')->name('loginAPI');
Route::get('plans', 'App\Http\Controllers\ServicesController@getPlans');
Route::get('iptv', 'App\Http\Controllers\ServicesController@getIPTV');
Route::get('services', 'App\Http\Controllers\ServicesController@getServices');
Route::post('customers', 'App\Http\Controllers\CustomerController@getCustomers');
Route::post('customers/recharge', 'App\Http\Controllers\CustomerController@rechargeRequest');

