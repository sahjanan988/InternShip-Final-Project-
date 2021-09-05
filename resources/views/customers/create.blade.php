@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('customers.index')}}">All Customers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Customer</li>
                        </ol>
                    </nav>
                    {{--<h4 class="mg-b-0 tx-spacing--1">Add New Employee</h4>--}}
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> {{session('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">Add New Customer</h6>
                        </div><!-- card-header -->
                        <div class="card-body pd-b-0">
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
                            <form id="create-user" action="{{route('customers.create')}}" method="post" data-parsley-validate>

                                @csrf

                                <fieldset class="form-fieldset mb-2">
                                <legend>Personal Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Customer Name: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" autocomplete="name" value="{{old('name')}}" required>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Phone Number: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                        <span class="input-group-text"> (+961)</span>
                                                    </div>
                                                    <input id="inputPhoneNumber" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="tel-national" value="{{old('phone')}}" required>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                        <legend class="mb-3 mt-4">Residential Information</legend>
                                        <div class="row mb-1">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Area: <span class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                        </div>
                                                        <select class="custom-select select2-dropdown select2-tags" name="area" required>
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
                                                    <label>Street: <span class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-road"></i></span>
                                                        </div>
                                                        <select class="custom-select select2-dropdown select2-tags" name="street" disabled required>
                                                            <option value="" {{(old('street') == '')  ? 'selected' : ''}}>Choose area first</option>
                                                            @foreach($streets as $street)
                                                                <option value="{{$street->id}}" {{(old('street') == $street->id)  ? 'selected' : ''}}>{{$street->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Building: <span class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                        </div>
                                                        <select class="custom-select select2-dropdown select2-tags" name="building" disabled required>
                                                            <option value="" {{(old('building') == '')  ? 'selected' : ''}}>Choose street first</option>
                                                            @foreach($buildings as $building)
                                                                <option value="{{$building->id}}" {{(old('building') == $building->id)  ? 'selected' : ''}}>{{$building->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col">
                                                <div class="form-group ">
                                                    <label>Box: <span class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                                        </div>
                                                        <select class="custom-select select2-dropdown select2-tags" name="box" disabled required>
                                                            <option value="" {{(old('box') == '')  ? 'selected' : ''}}>Choose building first</option>
                                                            @foreach($boxes as $box)
                                                                <option value="{{$box->id}}" {{(old('box') == $box->id)  ? 'selected' : ''}}>{{$box->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div><!-- form-group -->
                                            </div>
                                        </div>
                                </fieldset>


                                <fieldset class="form-fieldset mb-2">
                                <legend> User Credentials</legend>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Username: <span class="tx-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                                </div>
                                                <input type="text" name="username" class="form-control" placeholder="Enter Username" autocomplete="username" value="{{old('username')}}" required>
                                            </div>
                                        </div><!-- form-group -->
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Password: <span class="tx-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
                                            </div>
                                        </div><!-- form-group -->
                                    </div>
                                </div>

                                </fieldset>

                                <fieldset class="form-fieldset mb-2">
                                    <legend>Services</legend>

                                    <div class="row mb-1">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Plan: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                                    </div>
                                                    <select class="custom-select select2-dropdown select2-no-search" name="plan" required>
                                                        <option value="" {{(old('plan') == '')  ? 'selected' : ''}}>Choose one</option>
                                                        @foreach($plans as $plan)
                                                        <option value="{{$plan->id}}" {{(old('plan') == $plan->id)  ? 'selected' : ''}}>{{$plan->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mt-4 mb-4">
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="enableIPTV" name="enableIPTV" {{ old('enableIPTV') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="enableIPTV">Enable IPTV</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col">
                                            <div class="form-group">
                                                <label id="iptvLabel">IPTV: </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-tv"></i></span>
                                                    </div>
                                                    <select class="custom-select select2-dropdown select2-no-search" name="iptv" id="iptv"  {{ old('enableIPTV') ? '' : 'disabled' }}>
                                                        <option value="" {{(old('iptv') == '')  ? 'selected' : ''}}>Choose one</option>
                                                        @foreach($iptv as $tv)
                                                            <option value="{{$tv->id}}" {{(old('iptv') == $tv->id)  ? 'selected' : ''}}>{{$tv->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Services: </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                                    </div>
                                                    <select id="services" class="custom-select" name="service[]" id="service" multiple="multiple" >
                                                        @foreach($services as $service)
                                                            <option value="{{$service->id}}" {{old('service')?(in_array($service->id, old('service')) ? 'selected' : '') : ''}}>{{$service->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                </fieldset>

                                <fieldset class="form-fieldset mb-2">
                                    <legend>Administrative Information</legend>

                                    <div class="row mb-1">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Employee: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                                    </div>
                                                    <select class="custom-select" id="employee" name="employee" required>
                                                        <option value="" {{(old('employee') == '')  ? 'selected' : ''}}>Choose one</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->id}}" {{(old('employee') == $employee->id)  ? 'selected' : ''}}>{{$employee->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mt-4 mb-4">
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" value="1" class="custom-control-input" name="active" id="active" {{ old('active') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="active">Active</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4 mb-4">
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" value="1" class="custom-control-input" id="free_account" name="free_account" {{ old('free_account') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="free_account">Free Account</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Expires At: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                    </div>
                                                    <input id="inputExpire" type="text" name="expires_at" class="form-control" placeholder="Enter Expiry Date" value="{{old('expires_at')}}" required>

                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Custom Price: <span class="tx-gray-300">(Optional)</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                    </div>
                                                    <input id="inputCost" type="number" name="custom_price" class="form-control" placeholder="Enter custom price" value="{{old('custom_price')}}" >
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><strong>LBP</strong></span>
                                                    </div>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Discount:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                                    </div>
                                                    <input id="inputDiscount" type="number" name="discount" class="form-control" placeholder="Enter discount rate" value="{{old('discount')}}" >
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Notes:</label>
                                                <textarea class="form-control" rows="5" placeholder="Notes" name="notes">{{old('notes')}}</textarea>
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
    <script src="{{asset('lib/cleave.js/cleave.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/addons/cleave-phone.lb.js')}}"></script>
    <script src="{{asset('lib/select2/js/select2.min.js')}}"></script>

   <script type="text/javascript">

       let phone = new Cleave('#inputPhoneNumber', {
           phone: true,
           phoneRegionCode: 'LB'
       });

       $( function() {
           $('#inputExpire').datepicker({
               showOtherMonths: true,
               selectOtherMonths: true,
               changeMonth: true,
               changeYear: true
           });
       } );

       $( function() {
           $('#create-user').parsley({
               errorsContainer: function(el) {
                   return el.$element.closest('.form-group');
               },
               errorClass: 'is-invalid',
               successClass: 'is-valid',
           });
       } );


       $('#services').select2({
           placeholder: 'Choose one or more..',
       });

       $("#enableIPTV").on('change',function(){
           if ($("#enableIPTV").prop('checked')){
               $('select[name="iptv"]').prop('disabled',false).prop('required',true);
               $('#iptvLabel').append('<span class="tx-danger">*</span>');
           }else{
               $('select[name="iptv"]').prop('disabled',true).prop('required',false);
               $('#iptvLabel').empty().append('IPTV:');
           }
       });

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

       $(".select2-tags").select2({
           theme: "bootstrap",
           tags: true
       });

       $(".select2-dropdown").select2({
           theme: "bootstrap",
       });
       $(".select2-no-search").select2({
           theme: "bootstrap",
           minimumResultsForSearch: Infinity
       });

       $("#services").select2({
           theme: "bootstrap",
           placeholder: "Choose all services that apply.."
       });

   </script>
@endsection
