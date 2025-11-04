<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>

    <meta charset="utf-8" />
    <title> Gaam Ram - Member Dashboard </title>
    <link rel="shortcut icon" href="{{ asset('front/images/Gaam_Raam_logo.png') }}">
    <script src="{{ asset('member/backend/js/layout.js') }}"></script>
    <link href="{{ asset('member/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('member/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('member/backend/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('member/backend/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('member/backend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('css')

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

       @include('member.layouts.header')
        <div class="app-menu navbar-menu">
                 <div class="navbar-brand-box">
                    <span class="logo-sm">
                    <a href="{{ url('/') }}" target="_blank">
                         <img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="{{ asset('front/images/Gaam_Raam_logo.png') }}" style="width:121%; margin-left:-11%;" height="50">
                    </a>
                    </span>
                </div>
            @include('member.layouts.sidebar')

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

           @yield('content')
            <!-- End Page-content -->

            @include('member.layouts.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>





    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('member/backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('member/backend/js/plugins.js') }}"></script>
    <script src="{{ asset('member/backend/js/app.js') }}"></script>
    <script src="{{ asset('member/backend/js/dashboard.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   
@if (Session::has('success') || Session::has('error') || $errors->any())
<script>
    @if (Session::has('success'))
        var messageType = 'success';
        var messageColor = 'blue';
        var message = "{{ Session::get('success') }}";
    @elseif (Session::has('error'))
        var messageType = 'warning';
        var messageColor = 'orange';
        var message = "{{ Session::get('error') }}";
    @elseif ($errors->any())
        var messageType = 'error';
        var messageColor = 'red';
        var message = @json($errors->all());
    @endif

    if (Array.isArray(message)) {
        message.forEach(function (msg) {
            iziToast[messageType]({
                message: msg,
                position: 'topRight',
                timeout: 4000,
                displayMode: 0,
                color: messageColor,
                theme: 'light',
                messageColor: 'black',
            });
        });
    } else {
        iziToast[messageType]({
            message: message,
            position: 'topRight',
            timeout: 4000,
            displayMode: 0,
            color: messageColor,
            theme: 'light',
            messageColor: 'black',
        });
    }
</script>
@endif

<script>
        var logoutUrl = "{{ route('member.logout') }}";
</script>

@stack('js')
</body>
</html>