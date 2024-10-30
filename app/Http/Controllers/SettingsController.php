<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Settings;
use Carbon\Carbon;

use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function main(){
//        return view('home');
        return redirect()->route('customers.index');
    }

    public function index(){

        $settings = Settings::get()->first();
        return view('settings',compact('settings'));
    }
    public function setup(){
        if(file_exists( public_path() . '/initial.txt')){
            return view('setup');
        }else{
            abort(404, 'Unauthorized Access');
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255'],
            'url' => ['max:255'],
            'username' => ['string', 'max:255'],
            'password' => ['string', 'max:255'],
            'phone' => ['string', 'max:255'],

            'emp_name' => ['required', 'string', 'max:255'],
            'emp_phone' => ['required', 'string', 'max:255'],
            'emp_salary' => ['required', 'numeric','min:0','max:99999999'],
            'enrolled_at' => ['required', 'string', 'date'],
            'emp_username' => ['required', 'string','alpha_dash', 'max:255', 'unique:employees,username'],
            'password' => ['required', 'confirmed','string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('setup.index')
                ->withErrors($validator)
                ->withInput();
        }

        $settings= new Settings();
        $settings -> company_name = $request->name;
        $settings -> company_phone = $request->phone;
        $settings -> company_address = $request->address;
        $settings -> radius_url = $request->url;
        $settings -> radius_username = $request->radius_username;
        $settings -> radius_password = $request->radius_password;
        if($request->file('logo') != null) {
            $logo = $request->file('logo');
            $filename = 'logo_' . Carbon::now()->format('YmdHis') . '.' . $logo->extension();
            $logo_path = $logo->storeAs('logos', $filename, 'public');
            $settings->company_logo = $logo_path;
        }
        $settings->save();

        $user = new Employee();
        $user->name         = $request -> emp_name;
        $user->phone        = $request -> emp_phone;
        $user->enrolled_at  = date("Y-m-d",strtotime($request -> enrolled_at));
        $user->salary       = $request -> emp_salary;
        $user->username     = $request -> emp_username;
        $user->password     = Hash::make($request -> password);
        $user->role         = $request -> emp_role;
        $user -> save();

        unlink( public_path() . '/initial.txt');

        return redirect()->route('login');
    }

    public function update( Request $request){

        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255'],
            'url' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'password' => ['string', 'max:255'],
            'phone' => ['string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('settings.edit')
                ->withErrors($validator)
                ->withInput();
        }



        $settings=Settings::get()->first();
        $settings -> company_name = $request->name;
        $settings -> company_phone = $request->phone;
        $settings -> company_address = $request->address;
        $settings -> radius_url = $request->url;
        $settings -> radius_username = $request->username;
        $settings -> radius_password = $request->password;
        if($request->file('logo') != null) {
            $logo = $request->file('logo');
            $filename = 'logo_' . Carbon::now()->format('YmdHis') . '.' . $logo->extension();
            $logo_path = $logo->storeAs('logos', $filename, 'public');
            $settings->company_logo = $logo_path;
        }
        $settings->save();

        return redirect()->route('settings.index')->with(compact('settings'));
    }
}
