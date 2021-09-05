@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('services.index')}}">All Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Plan</li>
                        </ol>
                    </nav>
                    {{--<h4 class="mg-b-0 tx-spacing--1">Add New Employee</h4>--}}
                </div>
            </div>

            <div class="row row-xs">

                <div class="col mg-t-10">
                    <div class="card ht-lg-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class=" h4 mg-b-0">Edit Plan</h6>
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
                            <form id="edit-plan" action="{{route('plans.edit',$plan->id)}}" method="post" data-parsley-validate>

                                @csrf
                                @method('PUT')

                                <fieldset class="form-fieldset mb-2">
                                <legend>Plan Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Plan Name: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" placeholder="Enter plan name" value="{{(old('name') == '') ? $plan->name : old('name') }}" required>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Upload: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                                    </div>
                                                    <input id="inputUpload" type="text" name="upload" class="form-control" placeholder="Enter upload rate"  value="{{(old('upload') == '') ? $plan->upload : old('upload') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><strong>MB</strong></span>
                                                    </div>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Download: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-download"></i></span>
                                                    </div>
                                                    <input id="inputDownload" type="text" name="download" class="form-control" placeholder="Enter download rate"  value="{{(old('download') == '') ? $plan->download : old('download') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><strong>MB</strong></span>
                                                    </div>
                                                </div>
                                            </div><!-- form-group -->
                                        </div>
                                    </div>

                                </fieldset>
                                <fieldset class="form-fieldset mb-2">
                                <legend>Financial Information</legend>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Cost: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                    </div>
                                                    <input id="inputCost" type="number" name="cost" class="form-control" placeholder="Enter plan cost" value="{{(old('cost') == '') ? $plan->cost : old('cost') }}" required>
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
                                                <label>Retail Price: <span class="tx-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                                    </div>
                                                    <input id="inputPrice" type="number" name="price" class="form-control" placeholder="Enter retail price" value="{{(old('price') == '') ? $plan->price : old('price') }}" required>
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

   <script type="text/javascript">

       $( function() {
           $('#edit-plan').parsley({
               errorsContainer: function(el) {
                   return el.$element.closest('.form-group');
               },
               errorClass: 'is-invalid',
               successClass: 'is-valid',
           });
       } );
   </script>
@endsection
