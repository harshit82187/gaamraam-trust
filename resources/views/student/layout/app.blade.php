<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title> Student - Portal </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('front/images/Gaam_Raam_logo.png') }}">
    <link href="{{ asset('student/backend/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('student/backend/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('student/backend/js/layout.js') }}"></script>
    <link href="{{ asset('student/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('student/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('student/backend/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('student/backend/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('student/backend/css/card.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    @stack('css')
</head>

<body>

    <div id="layout-wrapper">

       @include('student.layout.header')

<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background-color:white;">
                <!-- Dark Logo-->
                <a href="{{url('/')}}" target="_blank" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('front/images/Gaam_Raam_logo.png')  }}" alt="" style="background-color:white;" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('front/images/Gaam_Raam_logo.png')  }}" alt="" style="background-color:white;" height="17" style="filter:grayscale(1);">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{url('/')}}" target="_blank" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('front/images/Gaam_Raam_logo.png')  }}" alt="" style="background-color:white;" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('front/images/Gaam_Raam_logo.png')  }}" alt="" style="height: 45px!important; filter:grayscale(1);" >
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            @include('student.layout.sidebar')

            <div class="sidebar-background"></div>
        </div>
       
        <div class="vertical-overlay"></div>


        <div class="main-content">

           @yield('content')
            <!-- End Page-content -->

            @include('student.layout.footer')
        </div>
      

    </div>



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

    <!-- <div class="customizer-setting d-none d-md-block">
        <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div> -->
   

    <!-- JAVASCRIPT -->
    <script src="{{ asset('student/backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('student/backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('student/backend/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('student/backend/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('student/backend/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('student/backend/js/plugins.js') }}"></script>
    <script src="{{ asset('student/backend/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('student/backend/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('student/backend/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('student/backend/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('student/backend/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ asset('student/backend/js/app.js') }}"></script>
    <script src="{{ asset('student/backend/js/custom.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(".js-example-basic-single,.js-example-basic-state,.js-example-basic-city,.js-example-basic-facility").select2({
            allowClear: true
        });
    </script>

    @if ((Session::has('success') || Session::has('error') || $errors->any()))
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
    function logout() {
        Swal.fire({
            title: 'Are you sure?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText:'Logout! ',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
				window.location.href = "{{ url('logout') }}";				
                console.log("Harshit");
            }
        });
    }
</script>  

<script>
    $(document).ready(function() {
        
        $('.summernote').summernote({
        placeholder: 'Write your content here',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
       });

    });
</script>
<script>
    $(document).ready(function() {
        $('.number').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@stack('js')
</body>


</html>