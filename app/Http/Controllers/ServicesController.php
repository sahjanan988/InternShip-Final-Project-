<?php

namespace App\Http\Controllers;

use App\Models\IPTV;
use App\Models\Plan;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{

    //Plan Functions
    public function services(){

        $plans = Plan::get();
        $services = Service::get();
        $iptvs = IPTV::get();

        return view('services.index', compact('plans','services','iptvs'));
    }

    public function createPlan(){
        return view('services.plans.create');
    }

    public function storePlan(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'upload' => ['required', 'string', 'max:255'],
            'download' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('plans.create')
                ->withErrors($validator)
                ->withInput();
        };

        $plan = new Plan();
        $plan->name          = $request -> name;
        $plan->upload        = $request -> upload;
        $plan->download      = $request -> download;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('plans.create')->with('success', 'Plan created successfully');
    }

    public function editPlan($id){
        $plan = Plan::find($id);
        return view('services.plans.edit',compact('plan'));
    }
    public function updatePlan(Request $request,  $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'upload' => ['required', 'string', 'max:255'],
            'download' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('plans.edit',$id)
                ->withErrors($validator)
                ->withInput();
        };

        $plan = Plan::find($id);
        $plan->name          = $request -> name;
        $plan->upload        = $request -> upload;
        $plan->download      = $request -> download;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('plans.edit', $id)->with('success', 'Plan modified successfully');

    }
    //TODO: Check for cascading when deleting while having customer on later phase
    public function deletePlan($id){

        $plan = Plan::find($id);
        $plan->delete();

        return redirect()->route('services.index')->with('deleted','Plan successfully deleted');
    }

    //API function
    public function getPlans(){

        $plans = Plan::get();
        return response()->json(['plans' => $plans->toArray(),'result' => true],200);
    }

    //iPTV Functions
    public function createTV(){
        return view('services.iptv.create');
    }

    public function storeTV(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('iptv.create')
                ->withErrors($validator)
                ->withInput();
        };

        $plan = new IPTV();
        $plan->name          = $request -> name;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('iptv.create')->with('success', 'Plan created successfully');
    }

    public function editTV($id){
        $plan = IPTV::find($id);
        return view('services.iptv.edit',compact('plan'));
    }
    public function updateTV(Request $request,  $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('iptv.edit',$id)
                ->withErrors($validator)
                ->withInput();
        };

        $plan = IPTV::find($id);
        $plan->name          = $request -> name;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('iptv.edit', $id)->with('success', 'Plan modified successfully');

    }
    //TODO: Check for cascading when deleting while having customer on later phase
    public function deleteTV($id){

        $plan = IPTV::find($id);
        $plan->delete();

        return redirect()->route('services.index')->with('deleted','Plan successfully deleted');
    }

    //API function
    public function getIPTV(){

        $plans = IPTV::get();
        return response()->json(['iptv' => $plans->toArray(),'result' => true],200);
    }


    //iPTV Functions
    public function createService(){
        return view('services.service.create');
    }

    public function storeService(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('services.create')
                ->withErrors($validator)
                ->withInput();
        };

        $plan = new Service();
        $plan->name          = $request -> name;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('services.create')->with('success', 'Service created successfully');
    }

    public function editService($id){
        $plan = Service::find($id);
        return view('services.service.edit',compact('plan'));
    }
    public function updateService(Request $request,  $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'cost' => ['required', 'numeric','min:0','max:99999999'],
            'price' => ['required', 'numeric','min:0','max:99999999'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('services.edit',$id)
                ->withErrors($validator)
                ->withInput();
        };

        $plan = Service::find($id);
        $plan->name          = $request -> name;
        $plan->cost          = $request -> cost;
        $plan->price         = $request -> price;
        $plan-> save();

        return redirect()->route('services.edit', $id)->with('success', 'Service modified successfully');

    }
    //TODO: Check for cascading when deleting while having customer on later phase
    public function deleteService($id){

        $plan = Service::find($id);
        $plan->delete();

        return redirect()->route('services.index')->with('deleted','Service successfully deleted');
    }

    //API function
    public function getServices(){

        $plans = Service::get();
        return response()->json(['services' => $plans->toArray(),'result' => true],200);
    }

}
