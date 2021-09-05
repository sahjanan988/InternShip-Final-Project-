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
                            <h6 class=" h4 mg-b-0">List of Employees</h6>
                            <a  href="{{route('register')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Employee</span></a>
                        </div><!-- card-header -->
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div data-label="Employees">
                                            <table id="employees" class="table">
                                                <thead>
                                                <tr>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p">Name</th>
                                                    <th class="desktop tablet-l">Phone</th>
                                                    <th class="desktop tablet-l">Salary</th>
                                                    <th class="desktop tablet-l">Enrolled At</th>
                                                    <th class="desktop tablet-l tablet-p mobile-l mobile-p wd-md-20p wd-sm-50p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($employees as $employee)
                                                    <tr>
                                                        <td>{{$employee->name}}</td>
                                                        <td id="phone">{{'+961 '. $employee->phone}}</td>
                                                        <td>{{$employee->salary}}</td>
                                                        <td>{{date("Y-m-d",strtotime($employee -> enrolled_at))}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('employees.edit',$employee->id)}}" class="btn btn-xs btn-primary pr-3"><i class="fas fa-edit tx-white"></i></a>
                                                            <a href="{{route('employees.delete',$employee->id)}}" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{$employee->id}}" ><i class="fas fa-trash tx-white"></i></a>
                                                            @include("layouts.partials.deletemodal",["id"=>$employee->id,"route" => 'employees.delete'])
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


        $('#employees').DataTable({
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
