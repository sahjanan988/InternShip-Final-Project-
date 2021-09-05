<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Employee Routes
Route::get('login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('login', 'App\Http\Controllers\AuthController@authenticate');
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
Route::get('employees/register', 'App\Http\Controllers\AuthController@register')->name('register')->middleware('auth');
Route::post('employees/register', 'App\Http\Controllers\AuthController@create');
Route::get('employees', 'App\Http\Controllers\AuthController@index')->name('employees.index')->middleware('auth');
Route::get('employees/edit/{id}', 'App\Http\Controllers\AuthController@edit')->name('employees.edit')->middleware('auth');
Route::put('employees/edit/{id}', 'App\Http\Controllers\AuthController@update');
Route::delete('employees/delete/{id}', 'App\Http\Controllers\AuthController@delete')->name('employees.delete')->middleware('auth');


//All Services
Route::get('services', 'App\Http\Controllers\ServicesController@services')->name('services.index')->middleware('auth');

//Plans Route
Route::get('plan/create', 'App\Http\Controllers\ServicesController@createPlan')->name('plans.create')->middleware('auth');
Route::post('plan/create', 'App\Http\Controllers\ServicesController@storePlan');
Route::get('plan/edit/{id}', 'App\Http\Controllers\ServicesController@editPlan')->name('plans.edit')->middleware('auth');
Route::put('plan/edit/{id}', 'App\Http\Controllers\ServicesController@updatePlan');
Route::delete('plan/delete/{id}', 'App\Http\Controllers\ServicesController@deletePlan')->name('plans.delete')->middleware('auth');

//iPTV Route
Route::get('iptv/create', 'App\Http\Controllers\ServicesController@createTV')->name('iptv.create')->middleware('auth');
Route::post('iptv/create', 'App\Http\Controllers\ServicesController@storeTV');
Route::get('iptv/edit/{id}', 'App\Http\Controllers\ServicesController@editTV')->name('iptv.edit')->middleware('auth');
Route::put('iptv/edit/{id}', 'App\Http\Controllers\ServicesController@updateTV');
Route::delete('iptv/delete/{id}', 'App\Http\Controllers\ServicesController@deleteTV')->name('iptv.delete')->middleware('auth');

//iPTV Route
Route::get('service/create', 'App\Http\Controllers\ServicesController@createService')->name('services.create')->middleware('auth');
Route::post('service/create', 'App\Http\Controllers\ServicesController@storeService');
Route::get('service/edit/{id}', 'App\Http\Controllers\ServicesController@editService')->name('services.edit')->middleware('auth');
Route::put('service/edit/{id}', 'App\Http\Controllers\ServicesController@updateService');
Route::delete('service/delete/{id}', 'App\Http\Controllers\ServicesController@deleteService')->name('services.delete')->middleware('auth');

//Customer Route
Route::get('customers', 'App\Http\Controllers\CustomerController@index')->name('customers.index')->middleware('auth');
Route::get('customers/create', 'App\Http\Controllers\CustomerController@create')->name('customers.create')->middleware('auth');
Route::post('customers/create', 'App\Http\Controllers\CustomerController@store');
Route::put('customers/edit/{id}', 'App\Http\Controllers\CustomerController@update')->name('customers.edit')->middleware('auth');;
Route::delete('customers/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->name('customers.delete')->middleware('auth');
Route::get('customers/view/{id}', 'App\Http\Controllers\CustomerController@view')->name('customers.view')->middleware('auth');
Route::post('customers/recharge/{id}', 'App\Http\Controllers\CustomerController@recharge')->name('customers.recharge')->middleware('auth');

//Dashboard Routes
Route::get('/', function () {return view('home');})->name('home')->middleware('auth');

//Cash Drawer Routes
Route::get('transactions', 'App\Http\Controllers\DrawerController@index')->name('drawer.index')->middleware('auth');
Route::get('transactions/create', 'App\Http\Controllers\DrawerController@create')->name('drawer.transaction')->middleware('auth');
Route::post('transactions/create', 'App\Http\Controllers\DrawerController@store');

//Ajax calls routes
Route::get('street/{id}','App\Http\Controllers\CustomerController@street')->name('customer.street')->middleware('auth');
Route::get('building/{id}','App\Http\Controllers\CustomerController@building')->name('customer.street')->middleware('auth');
Route::get('box/{id}','App\Http\Controllers\CustomerController@box')->name('customer.box')->middleware('auth');
Route::get('customer/list', 'App\Http\Controllers\CustomerController@customers')->name('customer.list');


//Trial routes
Route::get('customers/pdf','App\Http\Controllers\CustomerController@pdf');





