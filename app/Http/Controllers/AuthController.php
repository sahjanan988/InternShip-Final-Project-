<?php

namespace App\Http\Controllers;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function login() {
        if(auth()->check()){
            return redirect()->route('home');
        }
        return view('login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect()->route('home');
        }
        return redirect('login')->with('error', 'Opps! You have entered invalid credentials');
    }

    public function logout() {
        auth()->logout();
        return redirect('login');
    }

    public function register(){

        return view('register');
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric','min:0','max:99999999'],
            'enrolled_at' => ['required', 'string', 'date'],
            'username' => ['required', 'string','alpha_dash', 'max:255', 'unique:employees,username'],
            'password' => ['required', 'confirmed','string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        };

        $user = new Employee();
        $user->name         = $request -> name;
        $user->phone        = $request -> phone;
        $user->enrolled_at  = date("Y-m-d",strtotime($request -> enrolled_at));
        $user->salary       = $request -> salary;
        $user->username     = $request -> username;
        $user->password     = Hash::make($request -> password);
        $user->role         = $request -> role;
        $user -> save();

        return redirect()->route('register')->with('success', 'User created successfully');
    }

    public function index(){

        $employees = Employee::get();

        return view('employees.index', compact('employees'));
    }

    public function edit($id){
        $employee = Employee::find($id);

        return view('employees.edit',compact('employee'));
    }

    public function update(Request $request , $id){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric','min:0','max:99999999'],
            'enrolled_at' => ['required', 'string', 'date'],
            'password' => ['confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('employees.edit',$id)
                ->withErrors($validator)
                ->withInput();
        };

        $user = Employee::find($id);
        $user->name         = $request -> name;
        $user->phone        = $request -> phone;
        $user->enrolled_at  = date("Y-m-d",strtotime($request -> enrolled_at));
        $user->salary       = $request -> salary;
        $user->username     = $request -> username;
        if ($request ->password != ''){
            $user->password     = Hash::make($request -> password);
        }
        $user->role         = $request -> role;
        $user -> save();

        return redirect()->route('employees.edit',$id)->with('success', 'User edited successfully');
    }

    public function delete($id){
        $employee = Employee::find($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('deleted','Employee successfully deleted');
    }

    public function mobileAuth(Request $request){

        if (Employee::where('username',$request->username)->first() != null){
            $user = Employee::where('username',$request->username)->first();
            if (Hash::check($request->password,$user->password)){
                return response()->json(['message' => 'OK','result' => true],200);
            }else {
                return response()->json(['message' => 'wrong username or password','result' => false],403);
            }
        }else{
            return response()->json(['message' => 'wrong username or password','result' => false],403);
        }
    }

}
