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
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.auth.css') }}">
</head>
<body>

<div class="content content-fixed content-auth">
    <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div class="mx-wd-600">
                    <img src="{{ asset('assets/img/img15.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <!-- media-body -->
            <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60 ">
                <div class="wd-100p">

                    <h3 class="tx-color-01 mg-b-5">Sign In</h3>
                    <p class="tx-color-03 tx-16 mg-b-40">Welcome! Please signin to continue.</p>
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> {{session('error')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{route('login')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input  name="username" id="username" type="text" class="form-control" autocomplete="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mg-b-5">
                                <label class="mg-b-0-f">Password</label>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="current-password" placeholder="Enter your password">
                        </div>
                        <button class="btn btn-brand-02 btn-block">Sign In</button>
                    </form>
                </div>
            </div><!-- sign-wrapper -->
        </div><!-- media -->
    </div><!-- container -->
</div><!-- content -->

<footer class="footer">
    <div>
        <span>&copy; {{ now()->year }} {{ config('app.name') }} v1-alpha </span>
        <span>Created by <a href="https://ss-solutions.net">SS Solutions</a></span>
    </div>
</footer>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('assets/js/dashforge.js') }}"></script>


</body>
</html>
