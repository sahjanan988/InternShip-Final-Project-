@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container" style="max-width:100%">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    {{-- <h4 class="mg-b-0 tx-spacing--1">List of Employees</h4>--}}

                </div>
            </div>
            @if(session('deleted'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> {{session('deleted')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">List of Transactions</h6>
                            <a  href="{{route('drawer.transaction')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Transaction</span></a>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div data-label="Employees">
                                        <table id="drawer" class="table">
                                            <thead>
                                            <tr>
                                                <th class="desktop tablet-l tablet-p mobile-l mobile-p">ID</th>
                                                <th class="desktop tablet-l">Type</th>
                                                <th class="desktop tablet-l">Employee</th>
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

                                                    @if($transaction->type == 'Income')
                                                        <td class="text-center"><div style="vertical-align:middle"><span class=" h5 tx-success"><i class="fas fa-arrow-alt-circle-up"></i></span><span class="tx-bolder tx-success pl-2">{{$transaction->type}}</span></div></td>
                                                    @endif
                                                    @if($transaction->type == 'Expense')
                                                        <td class="text-center"><div style="vertical-align:middle"><span class=" h5 tx-danger"><i class="fas fa-arrow-alt-circle-up"></i></span><span class="tx-bolder tx-danger pl-2">{{$transaction->type}}</span></div></td>
                                                    @endif
                                                    <td>{{$transaction->employee()->first()->name}}</td>
                                                    @if($transaction->type == 'Income')
                                                    <td class="text-center tx-teal tx-16">+ {{$transaction->amount}} LBP</td>
                                                    @endif
                                                    @if($transaction->type == 'Expense')
                                                        <td class="text-center tx-pink tx-16">- {{$transaction->amount}} LBP</td>
                                                    @endif

                                                    <td class="text-center">{{date("Y-m-d",strtotime($transaction -> date))}}</td>
                                                    <td>{{$transaction->description}}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-xs btn-primary pr-3"><i class="fas fa-eye tx-white"></i></a>
                                                        <a href="#" class="btn btn-xs btn-warning pr-3"><i class="fas fa-sync-alt tx-white"></i></a>
                                                        <a href="#" class="btn btn-xs btn-danger"><i class="fas fa-trash tx-white"></i></a>
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


        $('#drawer').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    </script>
@endsection
