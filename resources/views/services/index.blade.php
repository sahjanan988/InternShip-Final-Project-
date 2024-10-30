@extends('layouts.app')

@section('content')

    <div class="content-body">
        <div class="container">
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
                        <div class="card-header p-2">
                                <ul class="nav nav-pills nav-justified" id="servicesTable" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="plans-tab" data-toggle="tab" href="#plans" role="tab" aria-controls="plans" aria-selected="true" ><div style="vertical-align:middle"><i class="fas fa-layer-group pr-1"></i><span class="tx-bolder">Plans</span></div></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="iptv-tab" data-toggle="tab" href="#iptv" role="tab" aria-controls="iptv" aria-selected="false" ><div style="vertical-align:middle"><i class="fas fa-tv pr-1"></i><span class="tx-bolder">IPTV</span></div></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false" ><div style="vertical-align:middle"><i class="fas fa-cogs pr-1"></i><span class="tx-bolder">Services</span></div></a>
                                    </li>
                                </ul>
                        </div>
                        <div class="card-body">
                                <div class="tab-content" id="servicesContent">
                                    <div class="tab-pane fade show active" id="plans" role="tabpanel" aria-labelledby="plans-tab">
                                        <div class="card">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h6 class=" h4 mg-b-0">List of Plans</h6>
                                                <a  href="{{route('plans.create')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Plan</span></a>
                                            </div><!-- card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div data-label="Plans">
                                                            <table id="plans-table" class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">Name</th>
                                                                    <th class="desktop tablet-l">Upload</th>
                                                                    <th class="desktop tablet-l">Download</th>
                                                                    <th class="desktop tablet-l">Cost</th>
                                                                    <th class="desktop tablet-l">Retail Price</th>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($plans as $plan)
                                                                    <tr>
                                                                        <td>{{$plan->name}}</td>
                                                                        <td>{{ $plan->upload}}</td>
                                                                        <td>{{$plan->download}}</td>
                                                                        <td>{{$plan->cost}}</td>
                                                                        <td>{{$plan->price}}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{route('plans.edit',$plan->id)}}" class="btn btn-xs btn-primary pr-3"><i class="fas fa-edit tx-white"></i></a>
                                                                            <a href="{{route('plans.delete',$plan->id)}}" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{$plan->id}}" ><i class="fas fa-trash tx-white"></i></a>
                                                                            @include('layouts.partials.deletemodal',['id'=>$plan->id,'route' => 'plans.delete'])
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
                                    <div class="tab-pane fade" id="iptv" role="tabpanel" aria-labelledby="iptv-tab">
                                        <div class="card">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h6 class=" h4 mg-b-0">List of IPTV Plans</h6>
                                                <a  href="{{route('iptv.create')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Plan</span></a>
                                            </div><!-- card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div data-label="iptv">
                                                            <table id="iptv-table" class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">Name</th>
                                                                    <th class="desktop tablet-l">Cost</th>
                                                                    <th class="desktop tablet-l">Retail Price</th>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($iptvs as $plan)
                                                                    <tr>
                                                                        <td>{{$plan->name}}</td>
                                                                        <td>{{$plan->cost}}</td>
                                                                        <td>{{$plan->price}}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{route('iptv.edit',$plan->id)}}" class="btn btn-xs btn-primary pr-3"><i class="fas fa-edit tx-white"></i></a>
                                                                            <a href="{{route('iptv.delete',$plan->id)}}" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{$plan->id}}-iptv" ><i class="fas fa-trash tx-white"></i></a>
                                                                            @include('layouts.partials.deletemodal',['id'=>$plan->id.'-iptv','route' => 'iptv.delete'])
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
                                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                                        <div class="card">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h6 class=" h4 mg-b-0">List of Services</h6>
                                                <a  href="{{route('services.create')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Service</span></a>
                                            </div><!-- card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div data-label="Services">
                                                            <table id="services-table" class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">Name</th>
                                                                    <th class="desktop tablet-l">Cost</th>
                                                                    <th class="desktop tablet-l">Retail Price</th>
                                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($services as $plan)
                                                                    <tr>
                                                                        <td>{{$plan->name}}</td>
                                                                        <td>{{$plan->cost}}</td>
                                                                        <td>{{$plan->price}}</td>
                                                                        <td class="text-center">
                                                                            <a href="{{route('services.edit',$plan->id)}}" class="btn btn-xs btn-primary pr-3"><i class="fas fa-edit tx-white"></i></a>
                                                                            <a href="{{route('services.delete',$plan->id)}}" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{$plan->id}}-services" ><i class="fas fa-trash tx-white"></i></a>
                                                                            @include('layouts.partials.deletemodal',['id'=>$plan->id.'-services','route' => 'services.delete'])
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
                                </div>
                        </div>
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


       var plans = $('#plans-table').DataTable({
            responsive: true,
           autoWidth: false,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var iptv = $('#iptv-table').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        var services = $('#services-table').DataTable({
            responsive: true,
            autoWidth: false,
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
