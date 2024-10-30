@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
                        </ol>
                    </nav>
                    {{--<h4 class="mg-b-0 tx-spacing--1">Add New Employee</h4>--}}
                </div>
            </div>

            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">Add New Employee</h6>
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
                            <form id="create-user" action="{{route('register')}}" method="post" data-parsley-validate>

                                @csrf

                                <fieldset class="form-fieldset mb-2">
                                <legend>Personal Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Name: <span class="tx-danger">*</span></label>
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
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Salary: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                                    </div>
                                                    <input id="inputSalary" type="number" name="salary" class="form-control" placeholder="Enter Salary" value="{{old('salary')}}" required>
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
                                                <label>Enrolled At: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                    </div>
                                                    <input id="inputEnroll" type="text" name="enrolled_at" class="form-control" placeholder="Enter Date of Enrollment" value="{{old('enrolled_at')}}" required>

                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>
                                </fieldset>


                                <fieldset class="form-fieldset mb-2">
                                <legend>Credentials</legend>
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

                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Confirm Password: <span class="tx-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input type="password"  data-parsley-equalto="#inputPassword" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
                                            </div>
                                        </div><!-- form-group -->
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Role: <span class="tx-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                                                </div>
                                            <select class="custom-select" name="role" required>
                                                   <option value="" {{(old('role') == '')  ? 'selected' : ''}}>Choose one</option>
												   <option value="admin" {{(old('role') == 'admin')  ? 'selected' : ''}}>Administrator</option>
													 <option value="collector" {{(old('role') == 'collector')  ? 'selected' : ''}}>Collector</option>


                                            </select>
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
    <script src="{{asset('lib/cleave.js/cleave.min.js')}}"></script>
    <script src="{{asset('lib/cleave.js/addons/cleave-phone.lb.js')}}"></script>

   <script type="text/javascript">
       var phone = new Cleave('#inputPhoneNumber', {
           phone: true,
           phoneRegionCode: 'LB'
       });

       $( function() {
           $('#inputEnroll').datepicker({
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
   </script>
@endsection
