<!-- Project Sidebar-->
<aside class="aside aside-fixed">

    <!-- Project Logo -->
    <div class="aside-header">
        <a href="{{route('home')}}" class="aside-logo">NMS<span>ALPHA</span></a>

        <!-- Responsive Close Button-->
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>

    <!-- Sidebar Body -->
    <div class="aside-body">

        <!-- logged User Panel -->
        <div class="aside-loggedin">
            <div class="d-flex align-items-center justify-content-start">
                <a href="" class="avatar avatar-online"><img src="{{asset('assets/img/avatar.svg' )}}" class="rounded-circle" alt=""></a>
                <div class="aside-alert-link">
                    <a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a>
                    <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>
                    <a href="{{route('logout')}}" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
                </div>
            </div>
            <div class="aside-loggedin-user">
                <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                    <h6 class="tx-semibold mg-b-0">{{ auth()->user()->name }}</h6>
                    <i data-feather="chevron-down"></i>
                </a>
                <p class="tx-color-03 tx-12 mg-b-0">{{auth()->user()->role}}</p>
            </div>
            <div class="collapse" id="loggedinMenu">
                <ul class="nav nav-aside mg-b-0">
                    <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
                    <li class="nav-item"><a href="" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>
                    <li class="nav-item"><a href="" class="nav-link"><i data-feather="settings"></i> <span> Settings</span></a></li>
                    <li class="nav-item"><a href="" class="nav-link"><i data-feather="help-circle"></i> <span>Help Center</span></a></li>
                    <li class="nav-item"><a href="{{route('logout')}}" class="nav-link"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>
        </div>


        <ul class="nav nav-aside">
            <li class="nav-label">Dashboard</li>
            <li class="nav-item active"><a href="{{route('home')}}" class="nav-link"><i data-feather="activity"></i> <span>Sales Monitoring</span></a></li>

            <li class="nav-label mg-t-25">Financial Activities</li>
            <li class="nav-item"><a href="{{route('drawer.index')}}" class="nav-link"><i data-feather="dollar-sign"></i> <span>Cash Drawer</span></a></li>
            <li class="nav-item"><a href="{{route('drawer.transaction')}}" class="nav-link"><i data-feather="plus-circle"></i> <span>Add Transaction</span></a></li>


            <li class="nav-label mg-t-25">Customers</li>
            <li class="nav-item"><a href="{{route('customers.index')}}" class="nav-link"><i data-feather="users"></i> <span>All Customers</span></a></li>
            <li class="nav-item"><a href="{{route('customers.create')}}" class="nav-link"><i data-feather="user-plus"></i> <span>Add Customer</span></a></li>

            <li class="nav-label mg-t-25">Employees</li>
            <li class="nav-item"><a href="{{route('employees.index')}}" class="nav-link"><i data-feather="users"></i> <span>All Employees</span></a></li>
            <li class="nav-label mg-t-25">Services</li>
            <li class="nav-item"><a href="{{route('services.index')}}" class="nav-link"><i data-feather="list"></i> <span>All Services</span></a></li>
        </ul>
    </div>
</aside>
