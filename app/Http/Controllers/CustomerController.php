<?php /** @noinspection PhpUnusedLocalVariableInspection */

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
use App\Models\Street;


use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class CustomerController extends Controller
{

    /** Load all Customers **/
    public function index(){
        return view('customers.index');
    }

    public function customers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::with('area','street','building','box','plan','iptv','services')->get();
            $output = Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="text-center"><a href="'. route('customers.view', $row->id) .'" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a> <a href="'. route('customers.delete', $row->id) .'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-'. $row->id .'"><i class="fas fa-trash"></i></a></div>'.  view("layouts.partials.deletemodal",["id"=>$row->id,"route" => 'customers.delete']);
                    return $actionBtn;
                })
                ->addColumn('select', function($row){
                    $selectBtn = '<input type="checkbox" value="'.$row->id .'">';
                    return $selectBtn;
                })
                ->rawColumns(['action','select'])
                ->make(true);
            return $output;
        }
        return '';
    }


    /** Add New Customer **/
    //TODO: Check for old values in form when validation fails for residential
    //TODO: Modify residental select to add values if option is not available
    public function create(){

        $employees = Employee::get();
        $plans = Plan::get();
        $iptv = IPTV::get();
        $services = Service::get();
        $areas = Area::get();
        $streets = Street::get();
        $buildings = Building::get();
        $boxes = Box::get();
        return view('customers.create',compact('employees','plans','iptv','services','areas','streets','buildings','boxes'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string','alpha_dash', 'max:255', 'unique:customers,username'],
            'password'=> ['required','string'],
            'expires_at'=> ['required', 'string', 'date'],
            'custom_price' => ['numeric','min:0','max:99999999'],
            'discount' => ['numeric','min:0','max:100'],
            'active' => ['boolean'],
            'free_account' => ['boolean'],


        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.create')
                ->withErrors($validator)
                ->withInput();
        }


        DB::transaction(function() use ($request) {

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->area_id = $request->area;
            $customer->street_id = $request->street;
            $customer->building_id = $request->building;
            $customer->box_id = $request->box;
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


    /** View Customer | Recharge | Update **/
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

    public function recharge(Request $request , $id){

        $validator = Validator::make($request->all(), [
            'new_expire'=> ['required', 'string', 'date'],
            'discount' => ['numeric','min:0','max:100'],
            'paid' => ['boolean'],
            'recharge_radius' => ['boolean'],


        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.view',$id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function() use ($request,$id) {

            $customer = Customer::find($id);
            //get costs
            $plan_cost = $customer->plan()->first()->cost;
            $iptv_cost = ($customer->iptv_id != null) ? $customer->iptv()->first()->cost : 0;
            $services_cost = 0;

            foreach ($customer->services()->get() as $service) {
                $services_cost += $service->cost;
            }
            $cost = $plan_cost + $iptv_cost + $services_cost;

            //get price
            $plan_price = ($customer->custom_price == 0) ? $customer->plan()->first()->cost : $customer->custom_price;
            $iptv_price = ($customer->iptv_id != null) ? $customer->iptv()->first()->price : 0;
            $services_price = 0;

            foreach ($customer->services()->get() as $service) {
                $services_price += $service->price;
            }
            $price = $plan_price + $iptv_price + $services_price;

            //get total
            $total = $price - ($price * $request->discount) / 100;

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
            $customer->save();

            if ($request->paid){
                $transaction = new LedgerBook();
                $transaction->type = 'Income';
                $transaction->amount = $total;
                $transaction->date = date('Y-m-d H:i:s');
                $transaction->description = 'recharge user '. $customer->username;
                $transaction->employee_id = auth()->user()->id;
                $transaction->save();
            }

        });

        return redirect()->route('customers.view',$id)->with('success', 'Customer recharged successfully');
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string','alpha_dash', 'max:255', 'unique:customers,username'],
            'password'=> ['required','string'],
            'expires_at'=> ['required', 'string', 'date'],
            'custom_price' => ['numeric','min:0','max:99999999'],
            'discount' => ['numeric','min:0','max:100'],
            'active' => ['boolean'],
            'free_account' => ['boolean'],


        ]);

        if ($validator->fails()) {
            return redirect()->route('customers.create')
                ->withErrors($validator)
                ->withInput();
        }


        DB::transaction(function() use ($request) {

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->area_id = $request->area;
            $customer->street_id = $request->street;
            $customer->building_id = $request->building;
            $customer->box_id = $request->box;
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


    /** Delete Customer **/
    public function delete($id){
        return redirect()->route('customers.index');
    }


    /**** AJAX & API functions****/

    //Ajax calls
    public function street($id){
        $streets = Street::select('id','name')->where("area_id",$id)->get();
        return json_encode($streets);
    }

    public function building($id){
        $buildings = Building::select('id','name')->where("street_id",$id)->get();
        return json_encode($buildings);
    }

    public function box($id){
        $boxes = Box::select('id','name')->where("building_id",$id)->get();
        return json_encode($boxes);
    }


    //API Calls
    public function getCustomers(Request $request){

	   $employee = Employee::where('username',$request->input('username'))->first();
	    if (Hash::check($request->password,$employee->password)){

           $customers = Customer::with('plan','area','street','building','box','iptv','services')->where('emp_id', $employee->id)->get();

           return response()->json(['customers' => $customers->toArray(),'result' => true]);
       }else{
           return response()->json(['message' => 'authentication failed','result' => false],401);
       }

    }

    public function rechargeRequest(Request $request){

    }

    public function pdf(){
        $customers = Customer::get();
        $pdf = PDF::loadView('customers.view',1);
        $pdf->save(storage_path().'_student.pdf');
        return $pdf->download('student.pdf');
    }

}
