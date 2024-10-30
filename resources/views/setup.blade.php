<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta -->
    <meta name="description" content="Network Management System">
    <meta name="theme-color" content="#ffffff">
    <!-- Favicon -->

    <title>{{ config('app.name')  }}</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.css') }}">
    <style>
        .aside-logo{
            font-size: 50px;
        }
        .home-slider-bg-one {
            position: absolute;
            top: -10%;
            right: 0;
            width: 100px;
            height: 200px;
            background-color: #015de1;
            border-radius: 20px;
            transform: rotate(30deg);
        }
        @media (min-width: 768px) {
            .home-slider-bg-one {
                top: -40%;
                right: -20%;
                width: 600px;
                height: 600px; }
        }
        @media (min-width: 992px) {
            .home-slider-bg-one {
                top: -45%;
                right: 0; }
        }
        @media (min-width: 1200px) {
            .home-slider-bg-one {
                top: -70%;
                right: -10%;
                width: 800px;
                height: 800px; }
        }

        .home-slider-bg-one::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 250px;
            background-color: #042893;
            bottom: 0;
            left: -410px;
            border-radius: 10px; }
        @media (min-width: 992px) {
            .home-slider-bg-one::before {
                right: -420px;
                border-radius: 20px; } }

        .home-slider-bg-one::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 100%;
            background-color: rgba(1, 104, 250, 0.6);
            bottom: 0;
            right: -410px;
            border-radius: 10px; }
        @media (min-width: 992px) {
            .home-slider-bg-one::after {
                right: -420px;
                border-radius: 20px; } }

        .hidden{
            display: none !important;
        }
    </style>
</head>
<body class="">

<div class="content content-fixed content-auth">

    <div>
        <div class="home-slider-bg-one">
        </div>
        <div class="container">
            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p rounded-10">
                        <div class="card-body ">
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
                            <form id="setupForm" action="{{route('setup.index')}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div id="setup-wizard">
                                            <h2 class="hidden">Welcome</h2>
                                            <section>
                                                <h1 class="tx-center">Welcome to</h1>
                                                <div class="tx-center">
                                                    <div class="aside-logo tx-center">SS<span>FINANCE</span></div>
                                                </div>
                                                <h3 class="tx-center pb-4">Let's setup some settings before we start.</h3>
                                                <ul class="list-group ">
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="btn btn-brand-02 btn-icon fa fas fa-building pr-2"></i>
                                                        <div>
                                                            <h6 class="tx-13 tx-inverse tx-semibold tx-brand-02 mg-b-0 pl-3">Company Information</h6>
                                                            <span class="d-block tx-11 text-muted pl-3">Specify company information such as name, phone, address and logo</span>
                                                        </div>
                                                    </li>

                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="btn btn-brand-02 btn-icon fa fas fa-globe pr-2"></i>
                                                        <div>
                                                            <h6 class="tx-13 tx-inverse tx-semibold tx-brand-02 mg-b-0 pl-3">Radius Information</h6>
                                                            <span class="d-block tx-11 text-muted pl-3">Specify information needed to connect to the radius dashboard.</span>
                                                        </div>
                                                    </li>

                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="btn btn-brand-02 btn-icon fa fas fa-user pr-2"></i>
                                                        <div>
                                                            <h6 class="tx-13 tx-inverse tx-semibold tx-brand-02 mg-b-0 pl-3">Administrative Information</h6>
                                                            <span class="d-block tx-11 text-muted pl-3">Specify information needed to create the admin user</span>
                                                        </div>
                                                    </li>

                                                    <li class="list-group-item d-flex align-items-center">
                                                        <i class="btn btn-brand-02 btn-icon fa fas fa-check pr-2"></i>
                                                        <div>
                                                            <h6 class="tx-13 tx-inverse tx-semibold tx-brand-02 mg-b-0 pl-3">Finish Registration</h6>
                                                            <span class="d-block tx-11 text-muted pl-3">Thank you for choosing us. Have an nice flight onboard!</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </section>
                                            <h2 class="hidden">Company Information</h2>
                                            <section>
                                                <h2 class="tx-center">Company Information</h2>
                                                <div class="divider-text">Please Enter Your Company Information</div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Company Name: <span class="tx-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                                </div>
                                                                <input type="text" id="cname" name="name" class="form-control" placeholder="Enter Company Name" autocomplete="name" value="{{old('name')}}" required>
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Phone Number: </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                                    <span class="input-group-text"> (+961)</span>
                                                                </div>
                                                                <input id="inputPhoneNumber" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{old('phone')}}" autocomplete="tel-national" >
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Company Address: </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                                </div>
                                                                <input type="text" name="address" class="form-control" placeholder="Enter Company Address" value="{{old('address')}}">
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group ">
                                                            <label>Company Logo:</label>

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="logo" name="logo" value="{{old('logo')}}">
                                                                    <label class="custom-file-label" for="logo">Choose file</label>
                                                                </div>
                                                            </div>

                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                            </section>
                                            <h2 class="pb-1 hidden">Radius Information</h2>
                                            <section>
                                                <h2 class="tx-center">Radius Information</h2>
                                                <div class="divider-text">Please Enter Your Radius Information</div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Radius URL:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                                </div>
                                                                <input type="text" name="url" class="form-control" placeholder="Enter Radius URL" value="{{old('url')}}">
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Username:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                                                </div>
                                                                <input type="text" name="radius_username" class="form-control " placeholder="Enter Username" autocomplete="username" value="{{old('radius_username')}}">
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Change Password:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                </div>
                                                                <input type="password" name="radius_password" class="form-control" placeholder="Enter password"  value="{{old('radius_password')}}">
                                                            </div>
                                                        </div><!-- form-group -->
                                                    </div>
                                                </div>
                                            </section>
                                            <h2 class="pb-1 hidden">Administrative Information</h2>
                                            <section>
                                                <h2 class="tx-center">Administrative Information</h2>
                                                <div class="divider-text">Please Enter Your Administrative Information</div>
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
                                                                    <input type="text" id="emp_name" name="emp_name" class="form-control" placeholder="Enter Name" autocomplete="name" value="{{old('emp_name')}}" required>
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
                                                                    <input id="inputPhoneNumberEmployee" type="text" name="emp_phone" class="form-control" placeholder="Enter Phone Number" autocomplete="tel-national" value="{{old('emp_phone')}}" required>
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
                                                                    <input id="inputSalary" type="number" name="emp_salary" class="form-control" placeholder="Enter Salary" value="{{old('emp_salary')}}" required>
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
                                                                    <input type="text" id="emp_username" name="emp_username" class="form-control" placeholder="Enter Username" autocomplete="username" value="{{old('emp_username')}}" required>
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
                                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
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
                                                                    <input type="password"  data-parsley-equalto="#password" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
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
                                                                    <select class="custom-select" name="emp_role" id="emp_role" required>
                                                                        <option value="" {{(old('emp_role') == '')  ? 'selected' : ''}}>Choose one</option>
                                                                        <option value="admin" {{(old('emp_role') == 'admin')  ? 'selected' : ''}}>Administrator</option>
                                                                        <option value="collector" {{(old('emp_role') == 'collector')  ? 'selected' : ''}}>Collector</option>
                                                                    </select>
                                                                </div>
                                                            </div><!-- form-group -->
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </section>
                                            <h2 class="pb-1 hidden">Finish</h2>
                                            <section>
                                                <h2 class="tx-center">Thank You for Choosing Us!</h2>
                                                <div class="divider-text">You Made it to the end</div>
                                                <div class="tx-center p-5">
                                                    <i class="fas fa-10x fa-arrow-alt-circle-right tx-success"></i>
                                                </div>
                                                <p class="mg-b-20 tx-16">
                                                    After finishing this setup successfully you'll be given the keys of <span class="tx-bold">SS Finance</span> ship. Enjoy your time
                                                    onboard and feel free to reach out to our support assistant via our previously provided contact information or by reaching out
                                                    via our website <a href="https://www.ss-solutions.net">here</a>.
                                                </p>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- card-body -->
                    </div>
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </div>
</div><!-- content -->


<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
<script src="{{asset('lib/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('lib/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{asset('lib/cleave.js/cleave.min.js')}}"></script>
<script src="{{asset('lib/cleave.js/addons/cleave-phone.lb.js')}}"></script>
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>


<script src="{{ asset('assets/js/dashforge.js') }}"></script>

<script type="text/javascript">
    $( function() {
        $('#inputEnroll').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true
        });
    } );



    $('#setup-wizard').steps({
        headerTag: 'h2',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
        stepsOrientation: 1,

        onStepChanging: function (event, currentIndex, newIndex) {
            if(currentIndex < newIndex) {
                // Step 1 form validation
                if(currentIndex === 0) {
                    return true;
                }

                if(currentIndex === 1) {
                    let cname = $('#cname').parsley(
                        {
                            errorsContainer: function(el) {
                                return el.$element.closest('.form-group');
                            },
                            errorClass: 'is-invalid',
                            successClass: 'is-valid',
                        }
                    );

                    if(cname.isValid()) {
                        return true;
                    } else {
                        cname.validate();
                    }
                }

                // Step 2 form validation
                if(currentIndex === 2) {
                    return true;
                }

                if(currentIndex === 3) {

                    let form = $('#setupForm').parsley(
                        {
                            errorsContainer: function(el) {
                                return el.$element.closest('.form-group');
                            },
                            errorClass: 'is-invalid',
                            successClass: 'is-valid',
                        }
                    );

                    if(form.isValid()) {
                        return true;
                    } else {
                        form.validate();
                    }
                }

                // Always allow step back to the previous step even if the current step is not valid.
            } else { return true; }
        },
        onFinishing: function (event, currentIndex, newIndex) {
            $('#setupForm').submit();
        },

    });

    let phone = new Cleave('#inputPhoneNumber', {
        phone: true,
        phoneRegionCode: 'LB'
    });

    let emp_phone = new Cleave('#inputPhoneNumberEmployee', {
        phone: true,
        phoneRegionCode: 'LB'
    });

    $('#logo').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>


</body>
</html>
