<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Network Management System">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->

    <title>{{ config('app.name') }}</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" >




    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/dashforge.profile.css')}}">
    <link id="dfMode" rel="stylesheet" href="{{ asset('assets/css/skin.cool.css') }}">
    <link id="dfSkin" rel="stylesheet" href="{{ asset('assets/css/skin.deepblue.css') }}">
</head>
<body>

@include('layouts.navs.sidebar')


<div class="content ht-100v pd-0">
    @include('layouts.navs.auth')
    @yield('content')
</div>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{asset('lib/prismjs/prism.js')}}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('assets/js/dashforge.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.aside.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.sampledata.js') }}"></script>
<!-- append theme customizer -->
<script src="{{ asset('lib/js-cookie/js.cookie.js')}}"></script>
<script>
    $(function(){
        'use script'

        window.darkMode = function(){
            $('.btn-white').addClass('btn-dark').removeClass('btn-white');
        }

        window.lightMode = function() {
            $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
        }

        var hasMode = Cookies.get('df-mode');
        if(hasMode === 'dark') {
            darkMode();
        } else {
            lightMode();
        }
    })
</script>

@yield('script')

</body>
</html>
