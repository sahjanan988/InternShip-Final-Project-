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
                            <h6 class=" h4 mg-b-0">List of Customers</h6>
                            <a  href="{{route('customers.create')}}" class="btn btn-primary btn-sm float-right "><span class="fas fa-plus pr-2 tx-white"></span><span class="h6 tx-white">Add Customer</span></a>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div data-label="Employees">
                                        <table id="customers" class="table table-sm" >
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


        $('#customers').DataTable({
            responsive: true,

            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('customer.list') }}",
            columns: [
                {
                    data: 'select',
                    name: 'select',
                },
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'username', name: 'username'},
                {data: 'area.name', name: 'area'},
                {data: 'street.name', name: 'street'},
                {data: 'building.name', name: 'building'},
                {data: 'box.name', name: 'box'},
                {data: 'plan.name', name: 'plan', searchable:true},
                {data: 'expires_at', name: 'expires_at'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
@endsection
