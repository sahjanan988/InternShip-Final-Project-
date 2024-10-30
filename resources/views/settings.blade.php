@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('settings.index')}}">Settings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">General Settings</h6>
                        </div><!-- card-header -->
                        <div class="card-body pd-b-0">
                            @if(session('success'))
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
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
                            <form id="settings" action="{{route('settings.edit')}}" method="post" enctype="multipart/form-data" data-parsley-validate>

                                @csrf
                                @method('PUT')

                                @if($settings->company_logo != '')
                                <div class="row mb-2">
                                    <div class="col tx-center">
                                            <img src="{{asset('storage/' . $settings->company_logo)}}" width="150" height="150" class="img-thumbnail" alt="Responsive image">
                                    </div>
                                </div>
                                @endif

                                <fieldset class="form-fieldset mb-2">
                                    <legend>Company Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Company Name: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" placeholder="Enter Company Name" autocomplete="name" value="{{$settings->company_name}}" required>
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
                                                    <input id="inputPhoneNumber" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="tel-national" value="{{$settings->company_phone}}">
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
                                                    <input type="text" name="address" class="form-control" placeholder="Enter Company Address" value="{{$settings->company_address}}">
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
                                                        <input type="file" class="custom-file-input" id="logo" name="logo">
                                                        <label class="custom-file-label" for="logo">Choose file</label>
                                                    </div>
                                                </div>

                                            </div><!-- form-group -->
                                        </div>
                                    </div>
                                </fieldset>


                                <fieldset class="form-fieldset mb-2">
                                    <legend>Radius Credentials</legend>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Radius URL:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    </div>
                                                    <input type="url" name="url" class="form-control" placeholder="Enter Radius URL" autocomplete="username" value="{{$settings->radius_url}}">
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
                                                    <input type="text" name="username" class="form-control " placeholder="Enter Username" autocomplete="username" value="{{$settings->radius_username}}">
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
                                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Enter password"  value="{{$settings->radius_password}}">
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Modify</button>
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
            $('#settings').parsley({
                errorsContainer: function(el) {
                    return el.$element.closest('.form-group');
                },
                errorClass: 'is-invalid',
                successClass: 'is-valid',
            });
        } );

        $('#logo').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

    </script>
@endsection
