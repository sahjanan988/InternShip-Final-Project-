<?php

/*
 * File name: AuthController.php
 * Description: used to manage authenticated users that have access to the system
 * Entity/Entities: Employees
 *
 * Authentication Functions:
 *  - login()
 *  - authenticate($request)
 *  - logout()
 *
 * Employee CRUD Functions:
 *  - register()
 *  - create($request)
 *  - index()
 *  - edit($id)
 *  - update($request, $id)
 *  - delete($id)
 *
 * API Functions:
 *  - mobileAuth($request)
 *
 * Reports Functions:
 *  -allEmployeesReport
 * */

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LedgerBook;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
Use PDF;


class AuthController extends Controller {

    /*************    Authentication Functions    **********/

    //used to view the login page
    public function login() {
        if(auth()->check()){
            return redirect()->route('home');
        }
        if(file_exists( public_path() . '/initial.txt')){
            return redirect()->route('setup.index');
        }
        return view('login');
    }

    //takes the request submitted on the login page  and authenticate the user with the table of employees.
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

    // used to deauthenticate a user and logout
    public function logout() {
        auth()->logout();
        return redirect('login');
    }

    /*************    Employee CRUD Functions    **********/

    // used to view the employee registeration page
    public function register(){

        return view('register');
    }

    // takes the request, validate it and create an entry with the data in the employee table
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

    // preview the list of employees page
    public function index(){

        $employees = Employee::get();

        return view('employees.index', compact('employees'));
    }

    // peview the edit page based on specific employee using $id
    public function edit($id){
        $employee = Employee::find($id);
        return view('employees.edit',compact('employee'));
    }

    //takes the request and updates the employee data accessed by $id while applying validation rules
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

    //delete employee based on passed $id
    public function delete($id){


        $employee = Employee::find($id);
        if($employee->customers()->count() >0){
            return redirect()->route('employees.index')->with('warning','Employee cannot be deleted. Please remove all customers linked to '. $employee->name . ' .');
        }else{
            $employee->delete();
            return redirect()->route('employees.index')->with('deleted','Employee successfully deleted');
        }
    }

    public function payroll($id){

        $employee = Employee::find($id);
        $transaction = new LedgerBook();

        $transaction->type = 'Expense';
        $transaction->amount = $employee->salary;
        $transaction->date = date("Y-m-d");
        $transaction->description = 'Monthly Salary for Mr/Mrs. ' . $employee->name;
        $transaction->employee_id = auth()->user()->id;
        $transaction->save();

        return redirect()->route('drawer.index')->with('success','Employee payment was recorded successfully.');

    }

    /*************    API Functions    **********/


    //authenticate users using an API call
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

    /*************    Reports Functions    **********/

    // generate a report with a list of all registered employees
    public function allEmployeesReport() {
        //retrieve data
        $data = Employee::all();

        $view = \View::make('employees.reports.employeesReport',['data' => $data]);
        $html_content = $view->render();

        PDF::SetTitle('List of Employees');
        PDF::SetFont('dejavu sans');
        PDF::SetFontSize('10px');
        PDF::AddPage('A4');
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_employees_list.pdf');
    }

}
