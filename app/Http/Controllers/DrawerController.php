<?php

namespace App\Http\Controllers;

use App\Models\LedgerBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrawerController extends Controller
{
    public function index(){
        $transactions = LedgerBook::get();
        return view('drawer.index',compact('transactions'));
    }

    public function create(){
        return view('drawer.transactions');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [

            'type' => ['required'],
            'issued_at'=> ['required', 'string', 'date'],
            'notes'  => ['string', 'max:255'],
            'amount' => ['numeric','min:0','max:99999999'],



        ]);

        if ($validator->fails()) {
            return redirect()->route('drawer.transaction')
                ->withErrors($validator)
                ->withInput();
        }

        $transaction = new LedgerBook();
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->date = date("Y-m-d", strtotime($request->issued_at));
        $transaction->description = $request->notes;
        $transaction->employee_id = auth()->user()->id;
        $transaction->save();

        return redirect()->route('drawer.transaction')->with('success', 'Transaction created successfully');
    }
}
