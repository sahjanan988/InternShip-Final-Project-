@extends('layouts.app')

@section('content')
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('drawer.index')}}">Drawer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Transaction</li>
                        </ol>
                    </nav>
                    {{--<h4 class="mg-b-0 tx-spacing--1">Add New Employee</h4>--}}
                </div>
            </div>

            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">Create New Transaction</h6>
                        </div><!-- card-header -->
                        <div class="card-body pd-b-0">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong> {{session('success')}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <h5 class="tx-danger"> Please check the following fields:</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="h6 tx-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form id="create-transaction" action="{{route('drawer.transaction')}}" method="post" data-parsley-validate>

                                @csrf

                                <fieldset class="form-fieldset mb-2">
                                    <legend>Transaction Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Type: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                                                    </div>
                                                    <select class="custom-select" name="type" required>
                                                        <option value="" >Choose one</option>
                                                        <option value="Income" >Income</option>
                                                        <option value="Expense" >Expense</option>
                                                    </select>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Issued At: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                    </div>
                                                    <input id="issued_at" type="text" name="issued_at" class="form-control" placeholder="Enter issued at date" value="" required>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Description: <span class="tx-danger">*</span></label>
                                                <textarea class="form-control" rows="3" placeholder="Notes" name="notes" required></textarea>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-fieldset mb-2">
                                    <legend>Financial Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Amount: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                    </div>
                                                    <input id="amount" type="number" name="amount" class="form-control" placeholder="Enter plan cost" value="" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                    </div>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- card-body -->
                    </div>
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>

@endsection
@section('script')

    <script src="{{asset('lib/parsleyjs/parsley.min.js')}}"></script>

    <script type="text/javascript">


            $('#issued_at').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true
            });

            $( function() {
                $('#create-transaction').parsley({
                    errorsContainer: function(el) {
                        return el.$element.closest('.form-group');
                    },
                    errorClass: 'is-invalid',
                    successClass: 'is-valid',
                });
            } );


    </script>
@endsection
