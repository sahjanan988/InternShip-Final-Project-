@extends('layouts.app')

@section('css')
    .ui-datepicker{z-index:9999 !important}
@endsection

@section('content')

    <div class="content-body">
        <div class="container" style="max-width:100%">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> {{session('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('deleted'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> {{session('deleted')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session('refunded'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong> {{session('refunded')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row row-xs mb-2">
                    <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
                        <div class="card bg-success card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Total Incomes (LBP)</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                        <h3 id="inputNumeral" class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$total_monthly_in}}</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-3x fa-money-bill-wave tx-white"></i>
                                </div>
                            </div>

                        </div>
                    </div><!-- col -->
                <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
                    <div class="card bg-danger card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Total Expenses (LBP)</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$total_monthly_out}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-money-bill-wave tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div><!-- col -->
                <div class="col-sm-6 col-lg-4 mg-t-10 mg-lg-t-0">
                    <div class="card bg-warning card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Due Balance (LBP)</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$total_due}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-money-bill-wave tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div><!-- col -->
                </div><!-- row -->

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">List of Transactions</h6>
                            <div class="float-right">
                                <a  href="{{route('drawer.transaction')}}" class="btn btn-primary btn-sm "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Transaction</span></a>
                                <a class="btn btn-info btn-sm" target="_blank" href="{{route('drawer.dailyReport')}}"><span class="fas fa-calendar tx-white"></span></a>
                                <a class="btn btn-brand-02 btn-sm" target="_blank" data-toggle="modal" data-target="#modal-print" ><span class="fas fa-print tx-white"></span></a>
                                <div class="modal fade" id="modal-print" tabIndex="-1" role="dialog" aria-labelledby="PrintModalLabel" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="PrintModalLabel">Print Options</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body tx-left">
                                                <form method="get" id="print-form" action="{{route('drawer.report')}}" target="_blank">
                                                    @csrf()
                                                    @method('PUT')
                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Employee: <span class="tx-gray-400">( Leave empty to get all employees )</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="employee" >
                                                                        <option value="" {{(old('employee') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($employees as $employee)
                                                                            <option value="{{$employee->id}}" {{(old('employee') == $employee->id)  ? 'selected' : ''}}>{{$employee->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">

                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label>From: </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                                    </div>
                                                                    <input id="from-date" type="text" name="from-date" class="form-control" placeholder="Enter From Date"  >

                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label>To:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                                    </div>
                                                                    <input id="to-date" type="text" name="to-date" class="form-control" placeholder="Enter To Date">

                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" value="1" class="custom-control-input" name="today" id="today" {{ old('today') ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="today"> Today Transactions Only </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="
                                            event.preventDefault();
                                            document.getElementById('print-form').submit();">Print</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div data-label="Employees">
                                        <table id="drawer" class="table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th class="desktop tablet-l tablet-p mobile-l mobile-p">ID</th>
                                                <th class="desktop tablet-l">Type</th>
                                                <th class="desktop tablet-l">Amount</th>
                                                <th class="desktop tablet-l">Date</th>
                                                <th class="desktop tablet-l">Description</th>
                                                <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($transactions as $transaction)
                                                <tr>
                                                    <td>{{$transaction->id}}</td>

                                                    @if($transaction->type == 'Income' || $transaction->type == 'Recharge')
                                                        <td class="text-center"><div style="vertical-align:middle"><span class=" h5 tx-success"><i class="fas fa-arrow-up"></i></span><span class="tx-bolder tx-success pl-2">{{$transaction->type}}</span></div></td>
                                                    @endif
                                                    @if($transaction->type == 'Expense')
                                                        <td class="text-center"><div style="vertical-align:middle"><span class=" h5 tx-danger"><i class="fas fa-arrow-down"></i></span><span class="tx-bolder tx-danger pl-2">{{$transaction->type}}</span></div></td>
                                                    @endif
                                                    @if($transaction->type == 'Income' || $transaction->type == 'Recharge')
                                                    <td class="tx-right tx-teal tx-16">+ {{$transaction->amount}} LBP</td>
                                                    @endif
                                                    @if($transaction->type == 'Expense')
                                                        <td class="tx-right tx-pink tx-16">- {{$transaction->amount}} LBP</td>
                                                    @endif

                                                    <td class="text-center">{{date("Y-m-d",strtotime($transaction -> date))}}</td>
                                                    <td>{{$transaction->description}}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-xs btn-primary pr-3"><i class="fas fa-print tx-white"></i></a>
                                                        @if($transaction->type == 'Recharge')
                                                            <a href="{{route('drawer.refund',$transaction->id)}}" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-refund-{{$transaction->id}}" ><i class="fas fa-sync tx-white"></i></a>
                                                            @include("layouts.partials.refundmodal",["id"=>$transaction->id,"route" => 'drawer.refund'])
                                                        @else
                                                            <a href="{{route('drawer.delete',$transaction->id)}}" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{$transaction->id}}" ><i class="fas fa-trash tx-white"></i></a>
                                                            @include("layouts.partials.deletemodal",["id"=>$transaction->id,"route" => 'drawer.delete'])
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><!-- card-body -->
                    </div>
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>


@endsection

@section('script')
    <script src="{{asset('lib/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/cleave.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/addons/cleave-phone.lb.js')}}"></script>
    <script src="{{asset('lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/select2/js/select2.min.js')}}"></script>

    <script type="text/javascript">

        var cleaveG = new Cleave('#inputNumeral', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        $('#drawer').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $( function() {
            $('#from-date').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true
            });

            $('#to-date').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true
            });
        } );

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    </script>
@endsection
