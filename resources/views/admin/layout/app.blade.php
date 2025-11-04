<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Gaam Raam - Admin</title>
		<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"		name="viewport"		/>
		<link	rel="icon"	href="{{ asset('front/images/Gaam_Raam_logo.png') }}"	type="image/x-icon"	/>
		<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.3/build/jodit.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
		@stack('css')
	</head>
	<body>
		<div class="wrapper">
			<!-- Sidebar -->
			@include('admin.layout.sidebar')
			<!-- End Sidebar -->
			<div class="main-panel">
				@include('admin.layout.header')
				<div class="container">
					<div class="page-inner">
						@yield('content')
					</div>
				</div>
				@include('admin.layout.footer')
			</div>
			<!-- Custom template | don't include it in your project! -->
			@include('admin.layout.setting')
			<!-- End Custom template -->
		</div>
		<!--   Core JS Files   -->
		{{-- <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js')  }}"></script> --}}
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/setting-demo.js') }}"></script>
		{{-- <script src="{{ asset('admin/assets/js/demo.js') }}"></script> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="assets/js/plugin/webfont/webfont.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jodit@3.24.3/build/jodit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

		<script>
			$("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
			  type: "line",
			  height: "70",
			  width: "100%",
			  lineWidth: "2",
			  lineColor: "#177dff",
			  fillColor: "rgba(23, 125, 255, 0.14)",
			});
			
			$("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
			  type: "line",
			  height: "70",
			  width: "100%",
			  lineWidth: "2",
			  lineColor: "#f3545d",
			  fillColor: "rgba(243, 84, 93, .14)",
			});
			
			$("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
			  type: "line",
			  height: "70",
			  width: "100%",
			  lineWidth: "2",
			  lineColor: "#ffa534",
			  fillColor: "rgba(255, 165, 52, .14)",
			});
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

		@if (Session::has('success') || Session::has('error') || $errors->any())
		<script>
			@if (Session::has('success'))
				var messageType = 'info';
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
			WebFont.load({
			google: { families: ["Public Sans:300,400,500,600,700"] },
			custom: {
				families: [
				"Font Awesome 5 Solid",
				"Font Awesome 5 Regular",
				"Font Awesome 5 Brands",
				"simple-line-icons",
				],
				urls: ["assets/css/fonts.min.css"],
			},
			active: function () {
				sessionStorage.fonts = true;
			},
			});
		</script>
        @stack('js')
	</body>
</html>