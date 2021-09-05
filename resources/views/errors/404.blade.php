<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="404 | Page Not Found ">

    <!-- Favicon -->

    <title>{{config('app.name')}}</title>

    <!-- vendor css -->
    <link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dashforge.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dashforge.auth.css')}}">
</head>
<body>

<div class="content content-fixed content-auth-alt">
    <div class="container ht-100p tx-center">
        <div class="ht-100p d-flex flex-column align-items-center justify-content-center">
            <div class="wd-70p wd-sm-250 wd-lg-300 mg-b-15"><img src="{{asset('assets/img/error-404.svg')}}" class="img-fluid" alt=""></div>
            <h1 class="tx-color-01 tx-24 tx-sm-32 tx-lg-36 mg-xl-b-5">404 Page Not Found</h1>
            <h5 class="tx-16 tx-sm-18 tx-lg-20 tx-normal mg-b-20">Oopps. The page you were looking for doesn't exist.</h5>
            <p class="tx-color-03 mg-b-30">You may have mistyped the address or the page may have moved. Try searching below.</p>
            <div class="d-flex mg-b-40">
                <a  href="{{route('home')}}" class="btn btn-brand-02 bd-0 mg-l-5 pd-sm-x-25">Go back Home</a>
            </div>
        </div>
    </div><!-- container -->
</div><!-- content -->

<footer class="footer">
    <div>
        <span>&copy; {{ now()->year }} {{ config('app.name') }} v1-alpha </span>
        <span>Created by <a href="https://ss-solutions.net">SS Solutions</a></span>
    </div>
</footer>

<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('lib/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/dashforge.js')}}"></script>

</body>
</html>
