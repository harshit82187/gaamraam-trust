<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
	<head>
		<meta charset="utf-8" />
		<title>Admin Reset Password - Gaam Raam Trust</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="{{ asset('front/images/Gaam_Raam_logo.png') }}">
		<script src="{{ asset('admin/assets/js/layout.js') }}"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css">
	</head>
	<body>
		@include('front.layout.validate')
		<div class="auth-page-wrapper pt-5">
			<!-- auth page bg -->
			<div class="auth-one-bg-position auth-one-bg" id="auth-particles">
				<div class="bg-overlay"></div>
				<div class="shape">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
						<path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
					</svg>
				</div>
			</div>
			<!-- auth page content -->
			<div class="auth-page-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center mt-sm-5 mb-4 text-white-50">
								<div>
									<a href="{{ url('/') }}" class="d-inline-block auth-logo">
									<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="" height="120px" width="140px">
									</a>
								</div>
							</div>
						</div>
					</div>
					<!-- end row -->
					<div class="row justify-content-center">
						<div class="col-md-8 col-lg-6 col-xl-5">
							<div class="card mt-4">
								<div class="card-body p-4">
									<div class="text-center mt-2">
										<h5 class="text-primary" style="color:#23b24b !important">Forget Password</h5>
									</div>
									<div class="p-2 mt-4">
										<form id="forgot-passward-form" action="{{ url('admin/forget-password') }}" method="POST" >
											@csrf
											<div class="mb-3">
												<label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
												<input type="email" class="form-control email_input" name="email" id="useremail" placeholder="Enter email address" required>
												<div class="invalid-feedback">
													Please Enter Email
												</div>
												<span class="text-danger error" id="emailError"></span>
											</div>											
											
											<div class="mt-4">
												<button class="btn btn-success w-100" type="submit">Send Reset Password Link</button>
											</div>
											<div class="mt-4 text-center">
												<div class="signin-other-title">
													<a href="{{ route('admin.login') }}" class="fs-13 mb-4 title">Remembered your password?Login</h5></a>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- footer -->
			<footer class="footer">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<p class="mb-0 text-muted">
									{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> 
									<a href="{{ url('/') }}" target="_blank">Gaam Raam Ngo</a> And Powered By <a href="{{ url('https://www.pearlorganisation.com/') }}" target="_blank">Pearl Organisation</a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<!-- end Footer -->
		</div>
		<!-- end auth-page-wrapper -->
		<!-- JAVASCRIPT -->
		<script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
		<script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
		<script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
		<script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
		<!-- particles js -->
		<script src="{{ asset('admin/assets/libs/particles.js/particles.js') }}"></script>
		<!-- particles app js -->
		<script src="{{ asset('admin/assets/js/pages/particles.app.js') }}"></script>
		<!-- validation init -->
		<script src="{{  asset('admin/assets/js/pages/form-validation.init.js')  }}"></script>
		<!-- password create init -->
		<script src="{{ asset('admin/assets/js/pages/passowrd-create.init.js') }}"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
		@if (Session::has('success') || Session::has('error') || Session::has('rate_limit_error') || $errors->any())
		<script>
			@if (Session::has('success'))
			    var messageType = 'info';
			    var messageColor = 'blue';
			    var message = "{{ Session::get('success') }}";
			@elseif (Session::has('rate_limit_error'))
			    var messageType = 'warning';
			    var messageColor = 'orange';
			    var message = "{{ Session::get('rate_limit_error') }}";
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
            $(document).on('submit', '#forgot-passward-form', function() {
                let btn = $('button[type="submit"]');
                btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
            });
        </script>
	</body>
</html>