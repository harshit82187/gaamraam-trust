<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"	/>
		<meta name="keywords" content="Online Education Learning Template" />
		<meta name="description" content="Gaam Raam" />
		<title>Gaam Raam Trust</title>
		<link rel="shortcut icon" href="{{ url($websiteLogo) }}" />
		<link rel="stylesheet" href="{{ url('front/css/plugins.css') }}" />
		<link rel="stylesheet" href="{{ url('front/css/search.css') }}" />
		<link rel="stylesheet" href="{{ url('front/css/base.css') }}" />
		<link rel="stylesheet" href="{{ url('front/css/styles.css') }}"  />
		<link rel="stylesheet" href="{{ url('front/css/style2.css') }}"  />
		<link rel="stylesheet" href="{{ asset('front/css/iziToast.min.css') }}" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<link rel="stylesheet" href="{{ url('front/css/swiper-bundle.min.css') }}" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:title" content="GaamRaam NGO | Free UPSC & SSC Preparation for Underprivileged Children" />
		<meta property="og:description" content="GaamRaam is a non-profit organization committed to empowering underprivileged children by offering free, high-quality coaching for UPSC and SSC exams. Join us in building a brighter, more educated future." />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="{{ url()->current() }}" />
		<meta property="og:image" content="{{ url($websiteLogo) }}" />
		<meta property="og:image:width" content="640" />
		<meta property="og:image:height" content="442" />
		<link rel="stylesheet" href="{{ url('front/file-uploader/css/jquery.fileuploader.min.css') }}">


		@stack('css')
	</head>
	<body>
		<!-- PAGE LOADING
			================================================== -->
		<div id="preloader"></div>
		<!-- MAIN WRAPPER
			================================================== -->
		<div class="main-wrapper">
			<!-- HEADER
				================================================== -->
			@include('front.layout.header')
			@yield('content')
			<!-- FOOTER
				================================================== -->
			@include('front.layout.footer')
		</div>
		<a href="#!" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
		<a href="https://wa.me/{{ $mobile1 }}?What May I help you" class="scroll-to-top-whatspp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
		<script src="{{ url('front/js/jquery.min.js') }}"></script>
		<script src="{{ url('front/js/popper.min.js') }}"></script>
		<script src="{{ url('front/js/bootstrap.min.js') }}"></script>
		<script src="{{ url('front/js/core.min.js') }}"></script>
		<script src="{{ url('front/js/search.js') }}"></script>
		<script src="{{ url('front/js/main.js') }}"></script>
		<script src="{{ url('front/js/plugins.js') }}"></script>
		<script src="{{ url('front/js/scripts.js') }}"></script>
		<script src="{{ url('front/js/jquery-3.6.0.min.js') }}"></script>
		<script src="{{ url('front/js/iziToast.min.js') }}"></script>
		<script src="{{ url('front/js/swiper-bundle.min.js') }}"></script>
		<script src="{{ url('front/js/main2.js') }}"></script>
		<link rel="stylesheet" href="{{ url('front/file-uploader/js/jquery.fileuploader.min.js') }}">
		<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
		@if (Session::has('success') || Session::has('error') || isset($errors) && $errors->any())
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


		@stack('js')
	</body>
</html>
