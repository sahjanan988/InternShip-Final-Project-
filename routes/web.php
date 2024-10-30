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

//Dashboard Routes
Route::get('/', 'App\Http\Controllers\SettingsController@main')->name('home')->middleware('auth');

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
Route::get('employees/payroll/{id}', 'App\Http\Controllers\AuthController@payroll')->name('employees.payroll')->middleware('auth');
Route::get('employees/pdf/list', 'App\Http\Controllers\AuthController@allEmployeesReport')->name('employees.employeesReport');

//All Services Route
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

//Services Route
Route::get('service/create', 'App\Http\Controllers\ServicesController@createService')->name('services.create')->middleware('auth');
Route::post('service/create', 'App\Http\Controllers\ServicesController@storeService');
Route::get('service/edit/{id}', 'App\Http\Controllers\ServicesController@editService')->name('services.edit')->middleware('auth');
Route::put('service/edit/{id}', 'App\Http\Controllers\ServicesController@updateService');
Route::delete('service/delete/{id}', 'App\Http\Controllers\ServicesController@deleteService')->name('services.delete')->middleware('auth');

//Customer Route
Route::get('customers', 'App\Http\Controllers\CustomerController@index')->name('customers.index')->middleware('auth');
Route::get('customers/create', 'App\Http\Controllers\CustomerController@create')->name('customers.create')->middleware('auth');
Route::post('customers/create', 'App\Http\Controllers\CustomerController@store');
Route::get('customers/view/{id}', 'App\Http\Controllers\CustomerController@view')->name('customers.view')->middleware('auth');
Route::put('customers/edit/{id}', 'App\Http\Controllers\CustomerController@update')->name('customers.edit')->middleware('auth');;
Route::delete('customers/delete/{id}', 'App\Http\Controllers\CustomerController@delete')->name('customers.delete')->middleware('auth');
Route::post('customers/recharge/{id}', 'App\Http\Controllers\CustomerController@recharge')->name('customers.recharge')->middleware('auth');
Route::get('customers/invoice/pay/{id}', 'App\Http\Controllers\CustomerController@pay')->name('customers.pay')->middleware('auth');
Route::get('customers/report/list', 'App\Http\Controllers\CustomerController@allCustomersReport')->name('customers.customersReport');

//Cash Drawer Routes
Route::get('transactions', 'App\Http\Controllers\DrawerController@index')->name('drawer.index')->middleware('auth');
Route::get('transactions/create', 'App\Http\Controllers\DrawerController@create')->name('drawer.transaction')->middleware('auth');
Route::post('transactions/create', 'App\Http\Controllers\DrawerController@store');
Route::delete('transactions/delete/{id}', 'App\Http\Controllers\DrawerController@delete')->name('drawer.delete')->middleware('auth');;
Route::delete('transactions/refund/{id}', 'App\Http\Controllers\DrawerController@refund')->name('drawer.refund')->middleware('auth');;
Route::get('transactions/report/list', 'App\Http\Controllers\DrawerController@createPDF')->name('drawer.report');
Route::get('transactions/report/daily', 'App\Http\Controllers\DrawerController@dailyReport')->name('drawer.dailyReport');

//Settings Route
Route::get('settings', 'App\Http\Controllers\SettingsController@index')->name('settings.index')->middleware('auth');
Route::put('settings/edit', 'App\Http\Controllers\SettingsController@update')->name('settings.edit')->middleware('auth');


//Setup Routes
Route::get('setup', 'App\Http\Controllers\SettingsController@setup')->name('setup.index');
Route::post('setup', 'App\Http\Controllers\SettingsController@store');
//Ajax calls routes
Route::get('street/{id}','App\Http\Controllers\CustomerController@street')->name('customer.street')->middleware('auth');
Route::get('building/{id}','App\Http\Controllers\CustomerController@building')->name('customer.building')->middleware('auth');
Route::get('box/{id}','App\Http\Controllers\CustomerController@box')->name('customer.box')->middleware('auth');
Route::get('customer/list', 'App\Http\Controllers\CustomerController@customers')->name('customer.list');

