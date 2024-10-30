@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container" style="max-width:100%">

            <div class="row row-xs mb-2">
                <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                    <div class="card bg-primary card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Total Users</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$total_users}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-users tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div><!-- col -->
                <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                    <div class="card bg-success card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Active Users</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$active_users}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-user tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                    <div class="card bg-danger card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Expired Users</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$expired_users}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-user-slash tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div><!-- col -->
                <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                    <div class="card bg-info card-body">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8 tx-white">Due Balance (LBP)</h6>
                                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 tx-white ">{{$due_amount}}</h3>
                                </div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-3x fa-money-bill-wave tx-white"></i>
                            </div>
                        </div>

                    </div>
                </div><!-- col -->
            </div><!-- row -->

            @if(session('deleted'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> {{session('deleted')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="collapse mb-3" id="advanced-filter">
                <div class="row">
                    <div class="col">
                        <div class="card bg-white-5 border-primary">
{{--                            <div class="card-header"><h6 class=" h5 mg-b-0 tx-white"><span class="fas fa-filter pr-2"></span>Advanced Search</h6></div>--}}
                            <div class="card-body">
                                <form id="advanced-search">
                                    <fieldset class="form-fieldset mb-2">
                                        <legend>Advanced Search</legend>
                                        <div class="row mb-3">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Customer Name: </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                        </div>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Customer Name" autocomplete="name">
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Phone Number:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                            <span class="input-group-text"> (+961)</span>
                                                        </div>
                                                        <input id="inputPhoneNumber" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="tel-national">
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Username: </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                                        </div>
                                                        <input type="text" name="username" class="form-control" placeholder="Enter Username" autocomplete="username" >
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Area:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                        </div>
                                                        <select class="custom-select" name="area" >
                                                            <option value="">Choose one</option>
                                                            @foreach($areas as $area)
                                                                <option value="{{$area->id}}">{{$area->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                                <div class="col-lg-3 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Street: </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-road"></i></span>
                                                            </div>
                                                            <select class="custom-select" name="street" disabled >
                                                                <option value="">Choose area first</option>
                                                            </select>
                                                        </div>
                                                    </div><!-- form-group -->
                                                </div>

                                                <div class="col-lg-3 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Building: </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                            </div>
                                                            <select class="custom-select" name="building" disabled >
                                                                <option value="" >Choose street first</option>
                                                            </select>
                                                        </div>
                                                    </div><!-- form-group -->
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Box: </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                            </div>
                                                            <select class="custom-select" name="box" disabled >
                                                                <option value="" >Choose building first</option>
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
                                                        <input id="ExpireFrom" type="text" name="expires-from" class="form-control" placeholder="Enter Expiry Date"  >

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
                                                        <input id="ExpireTo" type="text" name="expires-to" class="form-control" placeholder="Enter Expiry Date">

                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Plan: </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                                        </div>
                                                        <select class="custom-select" name="plan" >
                                                            <option value="" >Choose one</option>
                                                            @foreach($plans as $plan)
                                                                <option value="{{$plan->id}}" >{{$plan->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Employee: </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                        </div>
                                                        <select class="custom-select" name="employee" >
                                                            <option value="" >Choose one</option>
                                                            @foreach($employees as $employee)
                                                                <option value="{{$employee->id}}" >{{$employee->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col">
                                            <a id="reload" class="btn btn-lg btn-warning"><i class="fas fa-sync tx-white"></i></a>
                                        </div>
                                        <div class="col tx-right">
                                            <button type="reset" id="resetBtn" class="btn btn-lg btn-secondary">Clear</button>
                                            <button type="submit" class="btn btn-lg btn-primary"><i class="fas fa-search pr-1"></i>Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">List of Customers</h6>
                            <div class="float-right">
                                <a  href="{{route('customers.create')}}" class="btn btn-primary btn-sm "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Customer</span></a>
                                <a class="btn btn-brand-01 btn-sm" data-toggle="collapse" href="#advanced-filter" role="button" aria-expanded="false" aria-controls="advancedFilter"><span class="fas fa-filter tx-white"></span></a>
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
                                                <form method="get" id="print-form" action="{{route('customers.customersReport')}}" target="_blank">
                                                    @csrf()
                                                    @method('PUT')
                                                    <div class="row mb-1">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Area: <span class="tx-gray-400">( Leave empty to get all areas )</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                                    </div>
                                                                    <select class="custom-select" name="area">
                                                                        <option value="" {{(old('area') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        @foreach($areas as $area)
                                                                            <option value="{{$area->id}}" {{(old('area') == $area->id)  ? 'selected' : ''}}>{{$area->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
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

                                                    {{--                                                    <div class="row mt-4 mb-4">--}}
                                                    {{--                                                        <div class="col">--}}
                                                    {{--                                                            <div class="custom-control custom-switch">--}}
                                                    {{--                                                                <input type="checkbox" class="custom-control-input" id="duePayment" name="duePayment" {{ old('duePayment') ? 'checked' : '' }}>--}}
                                                    {{--                                                                <label class="custom-control-label" for="duePayment">Due Payments Only</label>--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
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
                                        <table id="customers" class="table table-sm" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-1p"></th>
                                                <th class="desktop tablet-l tablet-p" >Name</th>
                                                <th class="desktop tablet-l">Phone</th>
                                                <th class="desktop tablet-l mobile-l mobile-p">Username</th>
                                                <th class="desktop">Area</th>
                                                <th class="desktop">Street</th>
                                                <th class="desktop">Building</th>
                                                <th class="desktop">Box</th>
                                                <th class="desktop tablet-l">Plan</th>
                                                <th class="desktop tablet-l">Expires At</th>
                                                <th class="desktop tablet-l">Balance</th>
                                                <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-100 wd-sm-50">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

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
        let phone = new Cleave('#inputPhoneNumber', {
            phone: true,
            phoneRegionCode: 'LB'
        });



      var oTable = $('#customers').DataTable({
            responsive: true,

            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('customer.list') }}",
                data: function (d) {
                    d.name = $('input[name=name]').val();
                    d.phone = $('input[name=phone]').val();
                    d.username = $('input[name=username]').val();
                    d.area = $('select[name=area]').val();
                    d.street = $('select[name=street]').val();
                    d.building = $('select[name=building]').val();
                    d.box = $('select[name=box]').val();
                    d.plan = $('select[name=plan]').val();
                    d.employee = $('select[name=employee]').val();
                    d.expiresTo = $('input[name=expires-to]').val();
                    d.expiresFrom = $('input[name=expires-from]').val();
                }
            },
            columns: [
                {
                    data: 'select',
                    name: 'select',
                },
                {data: 'name', name: 'customers.name'},
                {data: 'phone', name: 'customers.phone'},
                {data: 'username', name: 'customers.username'},
                {data: 'area.name', name: 'area.name'},
                {data: 'street.name', name: 'street.name'},
                {data: 'building.name', name: 'building.name'},
                {data: 'box.name', name: 'box.name'},
                {data: 'plan.name', name: 'plan.name'},
                {data: 'expires_at', name: 'customers.expires_at'},
                {data: 'balance', name: 'balance',searchable: true,},
                {
                    data: 'action',
                    name: 'action',
                },
            ]
        });
       $('#advanced-search').on('submit', function(e) {
           oTable.draw();
           e.preventDefault();
       });

        $('#reload').on('click', function(e) {
            oTable.draw();
            e.preventDefault();
        });

       $('#resetBtn').on('click',function (){
           $('select[name="building"]').prop('disabled',true).empty().append('<option value="" selected>Choose Building</option>');
           $('select[name="street"]').prop('disabled',true).empty().append('<option value="" selected>Choose Street</option>');
           $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose Box</option>');
       })

        $(document).ready(function() {
            $('select[name="area"]').on('change', function() {
                let areaID = $(this).val();
                if(areaID) {

                    $.ajax({
                        url: '{{ url('street') }}/' + areaID ,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="street"]').prop('disabled',false).empty().append('<option value="" selected>Choose Street</option>');
                            $('select[name="building"]').prop('disabled',true).empty().append('<option value="" selected>Choose Building</option>');
                            $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose Box</option>');
                            $.each(data, function(key, value) {

                                $('select[name="street"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="street"]').prop('disabled',true).empty().append('<option value="" selected>Choose area first</option>');
                    $('select[name="building"]').prop('disabled',true).empty().append('<option value="" selected>Choose street first</option>');
                    $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose building first</option>');
                }
            });
        });

        $(document).ready(function() {
            $('select[name="street"]').on('change', function() {
                let streetID = $('select[name="street"]').val();
                if(streetID) {

                    $.ajax({
                        url: '{{ url('building') }}/' + streetID ,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="building"]').prop('disabled',false).empty().append('<option value="" selected>Choose Building</option>');
                            $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose Box</option>');
                            $.each(data, function(key, value) {

                                $('select[name="building"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="building"]').prop('disabled',true).empty().append('<option value="" selected>Choose street first</option>');
                    $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose building first</option>');
                }
            });
        });

        $(document).ready(function() {
            $('select[name="building"]').on('change', function() {
                let buildingID = $(this).val();
                if(buildingID) {
                    $.ajax({
                        url: '{{ url('box') }}/' + buildingID ,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="box"]').prop('disabled',false).empty().append('<option value="" selected>Choose Box</option>');
                            $.each(data, function(key, value) {

                                $('select[name="box"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="box"]').prop('disabled',true).empty().append('<option value="" selected>Choose building first</option>');
                }
            });
        });

        $( function() {
            $('#ExpireFrom').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true
            });

            $('#ExpireTo').datepicker({
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
