<?php

/*
 * File name: CustomerController.php
 * Description: used to manage customer  related functionalities and management
 * Entity/Entities: Customers
 *
 * Customers CRUD Functions:
 *  - index()
 *  - customers($request)
 *  - create()
 *  - store($request)
 *  - view($id)
 *  - update($request, $id)
 *  - delete($id)
 *
 * Supplemental Functions:
 *  - recharge($request, $id)
 *
 * AJAX Functions:
 *  - street($id)
 *  - building($id)
 *  - box($id)
 *
 * API Functions:
 *  - getCustomers($request)
 * */

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Box;
use App\Models\Building;
use App\Models\Customer;
use App\Models\CustomerInvoice;
use App\Models\CustomerService;
use App\Models\Employee;
use App\Models\IPTV;
use App\Models\LedgerBook;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Settings;
use App\Models\Street;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use PDF;

class CustomerController extends Controller
{
    /*************    Customers CRUD Functions    **********/

    // preview the list of customers page
    public function index(){
        $areas = Area::all();
        $employees = Employee::all();
        $plans = Plan::all();

        $total_users = Customer::count();
        $active_users = (Customer::where('active', '1')->count() == 0) ? Customer::where('active', '1')->count() : 0;
        $expired_users = (Customer::where('expires_at', '<=',date("Y-m-d"))->count() == 0)?Customer::where('expires_at', '<=',date("Y-m-d"))->count(): 0;
        $due_amount = CustomerInvoice::sum('due');

        return view('customers.index',compact('areas','employees','total_users','active_users','expired_users','due_amount','plans'));
    }

    // ajax call to load customers list in datatable
    public function customers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::with('area','street','building','box','plan','iptv','services','invoices')->select('customers.*');
            if ($request->has('name')) {
                $data->where('name', 'like', "%{$request->get('name')}%");
            }

            if ($request->has('phone')) {
                $data->where('phone', 'like', "%{$request->get('phone')}%");
            }

            if ($request->has('username')) {
                $data->where('username', 'like', "%{$request->get('username')}%");
            }
            if ($request->has('area') & $request->get('area') != '') {
                $data->where('area_id', $request->get('area'));
            }
            if ($request->has('street') & $request->get('street') != '') {
                $data->where('street_id', $request->get('street'));
            }
            if ($request->has('building') & $request->get('building') != '') {
                $data->where('building_id', $request->get('building'));
            }
            if ($request->has('box') & $request->get('box') != '') {
                $data->where('box_id', $request->get('box'));
            }
            if ($request->has('plan') & $request->get('plan') != '') {
                $data->where('plan_id', $request->get('plan'));
            }

            if ($request->has('employee') & $request->get('employee') != '') {
                $data->where('emp_id', $request->get('employee'));
            }

            if ($request->has('expiresTo') & $request->get('expiresTo') != '') {
                $data->where('expires_at', '<=',date("Y-m-d", strtotime($request->get('expiresTo'))));
            }

            if ($request->has('expiresFrom') & $request->get('expiresFrom') != '') {
                $data->where('expires_at', '>=',date("Y-m-d", strtotime($request->get('expiresFrom'))));
            }
            if (auth()->user()->role == 'collector') {
                $data->where('emp_id', auth()->user()->id);
            }

            $output = Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="text-center"><a href="'. route('customers.view', $row->id) .'" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a> <a href="'. route('customers.delete', $row->id) .'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-'. $row->id .'"><i class="fas fa-trash"></i></a></div>'.  view("layouts.partials.deletemodal",["id"=>$row->id,"route" => 'customers.delete']);
                    return $actionBtn;
                })
                ->addColumn('select', function($row){
                    $selectBtn = '<input type="checkbox" value="'.$row->id .'">';
                    return $selectBtn;
                })
                ->addColumn('balance', function($row){
                    $balance = CustomerInvoice::where('customer_id', $row->id)->sum('due');
                    return $balance .' LBP';
                })
                ->rawColumns(['action','select','balance'])
                ->make(true);
            return $output;
        }
        return '';
    }

    // used to view the costumer registration page
    public function create(){

        $employees = Employee::get();
        $plans = Plan::get();
        $iptv = IPTV::get();
        $services = Service::get();
        $areas = Area::get();
        return view('customers.create',compact('employees','plans','iptv','services','areas'));
    }

    // takes the request, validate it and create an entry with the data in the customers table
    public function store(Request $request){
        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:customers,username'],
            'password'=> ['required','string'],
            'expires_at'=> ['required', 'string', 'date'],
            'custom_price' => ['numeric','min:0','max:99999999'],
            'discount' => ['min:0','max:100'],
            'active' => ['boolean'],
            'free_account' => ['boolean'],
            'notes'  => ['max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function() use ($request) {



            $inputArea = Area::find($request->area);
            $inputStreet = Street::find($request->street);
            $inputBuilding = Building::find($request->building);
            $inputBox = Box::find($request->box);

            if($inputArea == null){
                $area = new Area();
                $area->name = $request->area;
                $area->save();

                $street = new Street();
                $street->name = $request->street;
                $street->area_id = $area->id;
                $street->save();

                $building = new Building();
                $building->name = $request->building;
                $building->street_id = $street->id;
                $building->save();

                $box = new Box();
                $box ->name = $request->box;
                $box ->building_id = $building->id;
                $box->save();
            }
            else if($inputStreet == null){
                $street = new Street();
                $street->name = $request->street;
                $street->area_id = $request->area;
                $street->save();

                $building = new Building();
                $building->name = $request->building;
                $building->street_id = $street->id;
                $building->save();

                $box = new Box();
                $box ->name = $request->box;
                $box ->building_id = $building->id;
                $box->save();
            }
            else if($inputBuilding == null){
                $building = new Building();
                $building->name = $request->building;
                $building->street_id = $request->street;
                $building->save();

                $box = new Box();
                $box ->name = $request->box;
                $box ->building_id = $building->id;
                $box->save();
            }
            else if($inputBox == null){
                $box = new Box();
                $box ->name = $request->box;
                $box ->building_id = $request->building;
                $box->save();
            }
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->area_id = ($inputArea == null)? $area->id :$request->area;
            $customer->street_id = ($inputArea == null || $inputStreet == null)? $street->id :$request->street;
            $customer->building_id = ($inputArea == null || $inputBuilding == null || $inputStreet == null)? $building->id :$request->building;
            $customer->box_id = ($inputArea == null || $inputBuilding == null || $inputStreet == null || $inputBox == null)? $box->id :$request->box;
            $customer->plan_id = $request->plan;

            if ($request->has('iptv')) {
                $customer->iptv_id = $request->iptv;
            } else {
                $customer->iptv_id = null;
            }

            $customer->expires_at = date("Y-m-d", strtotime($request->expires_at));
            $customer->custom_price = $request->custom_price;
            $customer->discount = $request->discount;
            $customer->username = $request->username;
            $customer->password = $request->password;
            $customer->emp_id = $request->employee;
            $customer->active = $request->has('active');
            $customer->free_account = $request->has('free_account');
            $customer->notes = $request->notes;

            $customer->save();

            if($request->old_balance != 0){
                $invoice = new CustomerInvoice();

                $invoice->customer_id = $customer->id;
                $invoice->employee_id = auth()->user()->id;
                $invoice->type = 'recharge';
                $invoice->cost = 0;
                $invoice->price = $request->old_balance;
                $invoice->discount = 0;
                $invoice->due = $request->old_balance;
                $invoice->margin = 0;
                $invoice->total = $request->old_balance;
                $invoice->issued_at = date('Y-m-d H:i:s');
                $invoice->notes = 'Invoice added on account creation for old balance prior this system';
                $invoice->save();


            }

            $services = $request->service;
            if ($services != null) {
                foreach ($services as $key => $service_id) {
                    $customerService = new CustomerService();
                    $customerService->customer_id = $customer->id;
                    $customerService->service_id = $service_id;
                    $customerService->save();
                }
            }
        });

        return redirect()->route('customers.create')->with('success', 'Customer created successfully');
    }


    //preview an employee based on passed $id
    public function view($id){
        $employees = Employee::get();
        $plans = Plan::get();
        $iptv = IPTV::get();
        $services = Service::get();
        $areas = Area::get();

        $customer = Customer::find($id);

        $serviceCost = 0;

        foreach ($customer->services()->get() as $service){
            $serviceCost += $service->price;
        }

        $balance = CustomerInvoice::where('customer_id', $id)->sum('due');

        $invoices = CustomerInvoice::with('employee')->where('customer_id',$id)->get();
        $dues = CustomerInvoice::with('employee')->where('customer_id',$id)->where('due','>',0)->get();

        return view('customers.view',compact('employees','invoices','dues','balance','serviceCost','plans','iptv','services','areas','customer'));
    }

    //take $request data and edit the data of customer based on passed $id while applying specific validations
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            //'username'  => ['required', 'string', 'max:255', 'unique:customers,username'],
            'expires_at'=> ['required', 'string', 'date'],
            'custom_price' => ['numeric','min:0','max:99999999'],
            'discount' => ['min:0','max:100'],
            'active' => ['boolean'],
            'free_account' => ['boolean'],
            'notes'  => ['max:255'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.view',$id)
                ->withErrors($validator)
                ->withInput();
        }


        DB::transaction(function() use ($request,$id) {



//            $inputArea = Area::find($request->area);
//
//            if($inputArea == null){
//                $area = new Area();
//                $area->name = $request->area;
//                $area->save();
//
//                $street = new Street();
//                $street->name = $request->street;
//                $street->area_id = $area->id;
//                $street->save();
//
//                $building = new Building();
//                $building->name = $request->building;
//                $building->street_id = $street->id;
//                $building->save();
//
//                $box = new Box();
//                $box ->name = $request->box;
//                $box ->building_id = $building->id;
//                $box->save();
//            }
            $customer = Customer::find($id);
            $customer->name = $request->name;
            $customer->phone = $request->phone;
//            $customer->area_id = ($inputArea == null)? $area->id :$request->area;
//            $customer->street_id = ($inputArea == null)? $street->id :$request->street;
//            $customer->building_id = ($inputArea == null)? $building->id :$request->building;
//            $customer->box_id = ($inputArea == null)? $box->id :$request->box;
            $customer->plan_id = $request->plan;

//            if ($request->has('iptv')) {
//                $customer->iptv_id = $request->iptv;
//            } else {
//                $customer->iptv_id = null;
//            }

            $customer->expires_at = date("Y-m-d", strtotime($request->expires_at));
            $customer->custom_price = $request->custom_price;
            $customer->discount = $request->discount;
            $customer->username = $request->username;
            $customer->password = ($request->password != '')? $request->password : $customer->password;
            $customer->emp_id = $request->employee;
            $customer->active = $request->has('active');
            $customer->free_account = $request->has('free_account');
            $customer->notes = $request->notes;

            $customer->save();

//            $services = $request->service;
//            if ($services != null) {
//                foreach ($services as $key => $service_id) {
//                    $customerService = new CustomerService();
//                    $customerService->customer_id = $customer->id;
//                    $customerService->service_id = $service_id;
//                    $customerService->save();
//                }
//            }
        });

        return redirect()->route('customers.view',$id)->with('success', 'Customer edited successfully');
    }


    //delete customer based on passed $id
    public function delete($id){
        return redirect()->route('customers.index');
    }

    /*************    Supplemental Functions    **********/


    //recharge customer's services, get costs, set ivoices, and if paid add invoice to ledgerBook
    public function recharge(Request $request , $id){

        $validator = Validator::make($request->all(), [
            'new_expire'=> ['required', 'string', 'date'],
            'discount' => ['numeric','min:0','max:100'],
            'paid' => ['boolean'],
            'recharge_radius' => ['boolean'],
            'notes'  => ['max:255'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.view',$id)
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::find($id);

        if($request->recharge_radius){
            $settings = Settings::get()->first();
            $recharge = $this->rechargeRequest($settings->radius_username,$settings->radius_password,$settings->radius_url,$customer->username);
            if($recharge->status() == '200'){
                $this->rechargeFunc($request,$id,$recharge,$customer);
                return redirect()->route('customers.view',$id)->with('success', 'Customer recharged successfully');
            }else{
                return redirect()->route('customers.view',$id)->with('failed', 'Customer could not be recharged on radius. Please check customer username or radius configuration in settings');
            }
        }else{
            $this->rechargeFunc($request,$id,null,$customer);
            return redirect()->route('customers.view',$id)->with('success', 'Customer recharged successfully');
        }
}

    public function pay(Request $request, $id){


        $invoice = CustomerInvoice::find($id);
        $customer = Customer::find($invoice->customer_id);

        $validator = Validator::make($request->all(), [
            'amount' => ['numeric','min:0','max:99999999'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.view',$customer->id)
                ->withErrors($validator)
                ->withInput();
        }

        $transaction = new LedgerBook();
        $transaction->type = 'Recharge';
        $transaction->amount = ($request->amount == 0)? $invoice->due : $request->amount;
        $transaction->date = date("Y-m-d");
        $transaction->description = 'Paid by '. $customer->name.' with Invoice #' . $invoice->id . '.';
        $transaction->employee_id = $customer->emp_id;
        $transaction->invoice_id = $invoice->id;
        $transaction->save();

        if($request->amount == 0){

            $invoice->due = 0;
            $invoice->save();
        }else{
            $invoice->due = $invoice->due - $request->amount;
            $invoice->save();
        }

        return redirect()->route('customers.view',$customer->id)->with('success', 'Transaction paid successfully for customer ');
    }

    // generate a report with a list of all registered employees
    public function allCustomersReport(Request $request) {


        if($request->area != 0 & $request->employee == 0 ){
            $data = Customer::where('area_id',$request->area)->get();
        }elseif ($request->area == 0 & $request->employee != 0 ){
            $data = Customer::where('emp_id',$request->employee)->get();
        }elseif ($request->area != 0 & $request->employee != 0 ){
            $data = Customer::where('area_id',$request->area)->where('emp_id',$request->employee)->get();
        }else{
            $data = Customer::all();
        }
        $area = ($request-> area != 0) ? Area::find($request->area)->name: '';
        $employee = ($request-> employee != 0) ? Employee::find($request->employee)->name: '';
        $view = \View::make('customers.reports.customersReport',['data' => $data, 'area' => $area ,'employee' => $employee]);
        $html_content = $view->render();

        PDF::SetTitle('List of Customers');
        PDF::SetFont('dejavu sans');
        PDF::SetFontSize('10px');

        PDF::SetMargins(10,30,20);
        PDF::AddPage('L');
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_customers_list.pdf');
    }
    /*************    AJAX Functions    **********/

    //get list streets based on area id
    public function street($id){
        $streets = Street::select('id','name')->where("area_id",$id)->get();
        return json_encode($streets);
    }

    //get list of buildings based on street id
    public function building($id){
        $buildings = Building::select('id','name')->where("street_id",$id)->get();
        return json_encode($buildings);
    }

    //get list of boxes based on building id
    public function box($id){
        $boxes = Box::select('id','name')->where("building_id",$id)->get();
        return json_encode($boxes);
    }

    /*************    API Functions    **********/

    //get customers list via an API call and it takes username and password as a parameter
    public function getCustomers(Request $request){

	   $employee = Employee::where('username',$request->input('username'))->first();
	    if (Hash::check($request->password,$employee->password)){

           $customers = Customer::with('plan','area','street','building','box','iptv','services')->where('emp_id', $employee->id)->get();

           return response()->json(['customers' => $customers->toArray(),'result' => true]);
       }else{
           return response()->json(['message' => 'authentication failed','result' => false],401);
       }

    }

    //implementation of recharge request
    private function rechargeRequest($username, $password,$url,$user){
        $body = [ 'selected' => [$user]];
        $json = json_encode($body);
        $token = $this->authRadius($username,$password, $url);
        $response = Http::withToken($token)->withBody($json,'application/json')->post($url.'/system/public/api/users/recharge');
        return $response;
    }

    private function authRadius($username,$password,$url){
        $login = Http::post($url.'/system/public/api/managers/login',[
            'USERNAME' => $username,
            'PASSWORD' => $password,
        ]);
        return json_decode($login)->token;
    }

    private function rechargeFunc($request , $id , $recharge , $customer){
        //get costs
        $plan_cost = $customer->plan()->first()->cost;
        $iptv_cost = ($customer->iptv_id != null) ? $customer->iptv()->first()->cost : 0;
        $services_cost = 0;

        foreach ($customer->services()->get() as $service){
            $services_cost += $service->cost;
        }
        $cost = $plan_cost  + $services_cost;

        //get price
        $plan_price = ($customer->custom_price == 0) ? $customer->plan()->first()->price : $customer->custom_price;
        $iptv_price = ($customer->iptv_id != null) ? $customer->iptv()->first()->price : 0;
        $services_price = 0;

        foreach ($customer->services()->get() as $service){
            $services_price += $service->price;
        }
        $price = $plan_price + $services_price;

        //get total
        $total = $price - ($price * $request->discount) /100;

        $invoice = new CustomerInvoice();

        $invoice->customer_id = $id;
        $invoice->employee_id = auth()->user()->id;
        $invoice->type = 'recharge';
        $invoice->cost = $cost;
        $invoice->price = $price;
        $invoice->discount = $request->discount;
        $invoice->due = ($request->paid) ? 0 : $total;
        $invoice->margin = $total - $cost;
        $invoice->total = $total;
        $invoice->issued_at = date('Y-m-d H:i:s');
        $invoice->notes = $request->notes;
        $invoice->save();



        $customer->expires_at = $request->new_expire;
        $customer->radius_exp = ($request->recharge_radius)? json_decode($recharge->body())->EXP_DATE : $customer->radius_exp;
        $customer->save();

        if($request->paid){
            $transaction = new LedgerBook();
            $transaction->type = "Recharge";
            $transaction->amount = $total;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->description = 'Recharge user ' . $customer->name . ' ';
            $transaction->employee_id = $customer->emp_id;
            $transaction->invoice_id = $invoice->id;
            $transaction->save();
        }
    }

}
