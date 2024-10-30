<?php

/*
 * File name: DrawerController.php
 * Description: used to manage transactions  in the ledger book
 * Entity/Entities: Customers
 *
 * Customers CRUD Functions:
 *  - index()
 *  - create()
 *  - store($request)
 *
 * Supplemental Functions:
 *  -
 * */


namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerInvoice;
use App\Models\Employee;
use App\Models\LedgerBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class DrawerController extends Controller
{
    //preview list of transactions from ledgerBook
    public function index(){
        $transactions = LedgerBook::get();
        $employees = Employee::get();

        $dateS = Carbon::now();
        $dateE = Carbon::now()->startOfMonth();

        $total_monthly_in = LedgerBook::where('type','Income')->sum('amount');
        $total_monthly_out = LedgerBook::where('type','Expense')->sum('amount');
        $total_due = CustomerInvoice::sum('due');
        return view('drawer.index',compact('transactions','employees', 'total_monthly_in','total_monthly_out','total_due'));
    }

    //view transaction registration page
    public function create(){
        return view('drawer.transactions');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'issued_at'=> ['required', 'string', 'date'],
            'amount' => ['numeric','min:0','max:99999999'],
            'notes'  => ['string', 'max:255'],

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

        return redirect()->route('drawer.index')->with('success', 'Transaction ( '. $request->type .' ) added successfully');
    }

    public function delete($id){
        $transaction= LedgerBook::find($id);
        $transaction->delete();
        return redirect()->route('drawer.index')->with('deleted', 'Transaction deleted successfully');
    }

    public function refund($id){
        $transaction= LedgerBook::find($id);
        $invoice = CustomerInvoice::find($transaction->invoice_id);
        $invoice->due = $invoice->due + $transaction->amount;
        $invoice->save();
        $transaction->delete();
        return redirect()->route('drawer.index')->with('refunded', 'Transaction refunded successfully');
    }

    // Generate PDF
    public function createPDF(Request $request) {

        $data = LedgerBook::query();
        $data->when($request->has('employee') && $request->employee != 0,function ($data) use ($request){
                $data->where('employee_id',$request->employee);
        });
        $data->when($request->has('from-date') && $request->get('from-date') != '',function ($data) use ($request){
                $data->where('date', '>=',date("Y-m-d", strtotime($request->get('from-date'))));
        });
        $data->when($request->has('to-date') && $request->get('to-date') != '',function ($data) use ($request){
                $data->where('date', '<=',date("Y-m-d", strtotime($request->get('to-date'))));
        });
        $data->when($request->has('today'),function ($data) use ($request){
                $data->where('date',date('Y-m-d'));
        });

        $fromdate = $request->get('from-date');
        $todate = $request->get('to-date');


        $transactions = $data->get();

        $view = \View::make('drawer.reports.transactionsReport',['data' => $transactions,'from' => $fromdate, 'to' => $todate]);
        $html_content = $view->render();

        PDF::SetTitle('List of Transactions');
        PDF::SetFont('dejavu sans');
        PDF::SetFontSize('10px');
        PDF::SetMargins(20,20,20,20, true);
        PDF::AddPage('L','','A4');
        PDF::SetAutoPageBreak(true,0);
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_transactions_list.pdf');
    }

    public function dailyReport() {

        $data = LedgerBook::where('date',date('Y-m-d'))->get();


        $view = \View::make('drawer.reports.dailyReport',['data' => $data]);
        $html_content = $view->render();

        PDF::SetTitle('List of Transactions');
        PDF::SetFont('dejavu sans');
        PDF::SetFontSize('10px');
        PDF::SetMargins(20,20,20,20, true);
        PDF::AddPage('L','','A4');
        PDF::SetAutoPageBreak(true,0);
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_transactions_daily_report.pdf');
    }
}
