@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    
    .select2-container{
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single{
        height: 37px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 40px;
    }
    .password-wrapper {
    position: relative;
    }

    .password-wrapper input {
        padding-right: 40px; /* make space for eye icon */
    }

    .password-wrapper .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }

</style>
@endpush

<div id="paymentLoader" class="loader-overlay d-none"  >
    <div class="loader"></div>
    <p class="processing" >⏳ Processing, Please Wait...</p>
</div>
<div class="card" style="padding:0px !important;">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/graduated.png') }}" width="40px" width="40px">
		<h3 class="mt-3">Add New Student </h3>
	</div>
</div>
<div id="paymentLoader" class="payment-loader-overlay d-none">
	<p class="payment-processing">⏳ Processing , Please Wait...</p>
</div>
<div class="row">
	<div class="col-12">
		@if(session()->get('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session()->get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@if ($errors->any())
		<div class="alert alert-danger alert-dismissible fade show">
			<ul>
				@foreach ($errors->all() as $error)
				<li style="font-size:larger;">{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="enrool-student" action="{{ route('admin.enrool-student-save') }}" method="post" enctype="multipart/form-data" class="text-start">
			@csrf                  
			<div class="card">
				<div class="card-body">
					<h5 class="mb-0 page-header-title text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						Student Information
					</h5>
					<div class="row">						
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="title-color">Full Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control alphabet @error('name') is-invalid @enderror" id="name" placeholder="Enter Student Full Name" required>
								@error('name') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label for="name" class="title-color">Blood Group<span class="text-danger">*</span></label>
								<select name="blood_group" id="blood_group" class="form-control select @error('blood_group') is-invalid @enderror" required>
									<option value="A+" >A+</option>
									<option value="A−">A−</option>
									<option value="B+" >B+</option>
									<option value="B-">B-</option>
									<option value="AB+" >AB+</option>
									<option value="AB−">AB−</option>
									<option value="O+" >O+</option>
									<option value="O-">O-</option>
								</select>
								@error('blood_group') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
						
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="title-color">
                                    Password (Password Should Be 8 Character) <span class="text-danger">*</span>
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="one-time-code" id="password" placeholder="Create Password" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#password"></i>
                                </div>
                                @error('password') <p style="color:red;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="title-color">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" name="cpassword" class="form-control"
                                        autocomplete="one-time-code" id="cpassword" placeholder="Enter Password Again" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#cpassword"></i>
                                </div>
                                <span class="password-error text-danger"></span>
                            </div>
                        </div>

						
						<div class="col-md-6">
							<div class="form-group">
								<label for="image" class="title-color">Profile Photo </label>
								<input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept=".jpeg,.jpg,.png,.webp" >
							</div>
							@error('image') <p style="color:red;">{{ $message }}</p> @enderror
						</div>
						
					
						<div class="col-md-6">
							<div class="form-group">
								<label for="course" class="title-color">Course <span class="text-danger">*</span></label>
								<select class="form-select select2 @error('course') is-invalid @enderror" name="course" id="course" required >
									<option disabled selected >--Select Course--</option>
									<option value="UPSC">UPSC</option>
								</select>
								@error('course') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
                       <div class="row mb-3 mt-3">
                            <!-- Email Section -->
                            <div class="col-md-6">
                                <label class="title-color">Email <span class="text-danger">*</span></label>
                                <div class="input-group group_field">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" id="email" placeholder="Enter Student Email" required>
                                    <div class="input-group-append" id="sendEmailOtpContainer">
                                        <button type="button" class="btn btn-primary"  id="sendEmailOtpButton" onclick="sendEmailOtp()">Send Email OTP</button>
                                    </div>
                                </div>
                                <span class="text-danger" id="regEmailError"></span>
                                <div class="mt-2" id="emailOtpContainer" style="display: none;">
                                    <div class="input-group group_field">
                                        <input class="form-control" name="email_otp" type="text" id="email_otp" placeholder="Enter Email OTP">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" id="emailOtpVerifyButton" onclick="verifyEmailOtp()">Verify OTP</button>
                                        </div>
                                    </div>
                                </div>
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                <span class="text-danger error-msg">@error('email') {{ $message }} @enderror</span>
                            </div>

                            <!-- Mobile Section -->
                            <div class="col-md-6">
                                <label class="title-color">Mobile Number <span class="text-danger">*</span></label>
                                <div class="input-group group_field">
                                    <input class="form-control number @error('mobile') is-invalid @enderror" name="mobile" type="text" id="mobile" placeholder="Enter Student Mobile Number" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" id="sendMobileOtpButton" onclick="sendMobileOtp()">Send Mobile OTP</button>
                                    </div>                                    
                                </div>
                                <span class="text-danger" id="regMobileError"></span>
                                <div class="mt-2" id="mobileOtpContainer" style="display: none;">
                                    <div class="input-group group_field">
                                        <input class="form-control" name="mobile_otp" type="text" id="mobile_otp" placeholder="Enter Mobile OTP">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" id="verifyMobileOtpButton" onclick="verifyMobileOtp()">Verify OTP</button>
                                        </div>
                                    </div>
                                </div>
                                @error('mobile') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <span class="text-danger error-msg">@error('mobile') {{ $message }} @enderror</span>
                        </div>

                       
					
						<div class="d-flex justify-content-end gap-3 mt-5">
							<button type="reset" id="reset" class="btn btn-secondary px-4">Reset</button>
							<button type="submit" id="submit-button" class="btn btn-primary px-4">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@push('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
	    $('.select2').select2({
	        allowClear: true,
	        width: '300px'
	    });
	});
</script>

<script>
$(document).ready(function () {
    $('.password-toggle').on('click', function () {
        const input = $($(this).attr('toggle'));
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);

        // Toggle the icon
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});
</script>

<script>
    $(document).ready(function () {
        $('#enrool-student').on('submit', function (e) {
            e.preventDefault(); // prevent default submit
            let isValid = true;

            // Clear previous errors
            $('.text-danger.error-msg').remove();

            function showError(input, message) {
                isValid = false;
                console.log('Validation Error:', message);
                $(`<span class="text-danger error-msg">${message}</span>`).insertAfter(input);
            }

            // Validate required fields
            const fieldsToValidate = [
                { selector: 'input[name="name"]', name: 'Full Name' },
                { selector: 'input[name="email"]', name: 'Email' },
                { selector: 'input[name="mobile"]', name: 'Mobile Number' },
                { selector: 'input[name="password"]', name: 'Password' },
                { selector: 'input[name="cpassword"]', name: 'Confirm Password' },
                { selector: 'select[name="blood_group"]', name: 'Blood Group' },
                { selector: 'select[name="course"]', name: 'Course' }
            ];

            fieldsToValidate.forEach(field => {
                const input = $(field.selector);
                if (!input.val()) {
                    console.log(`Field: ${field.selector}, Message: ${field.name} is required`);
                    showError(input, `${field.name} is required`);
                }
            });

            // Password match check
            const password = $('input[name="password"]').val();
            const cpassword = $('input[name="cpassword"]').val();
            if (password && password.length < 8) {
                showError($('input[name="password"]'), 'Password must be at least 8 characters long');
            } else if (password && cpassword && password !== cpassword) {
                showError($('input[name="cpassword"]'), 'Passwords do not match');
            }

            // ✅ Check if email and mobile fields are readonly
            const emailInput = $('input[name="email"]');
            const mobileInput = $('input[name="mobile"]');
            if (!emailInput.prop('readonly')) {
                    $('#emailOtpContainer').after('<span class="text-danger email-error">Please verify Email before submitting.</span>');

            }
            if (!mobileInput.prop('readonly')) {
                $('.error-msg').insertAfter('#mobileOtpContainer');
                $('#mobileOtpContainer').after('<span class="text-danger mobile-error">Please verify Mobile Number before submitting.</span>');
            }

            // Submit if valid
            if (isValid) {
                console.log("Submit Successfully!");
                $('#paymentLoader').removeClass('d-none');
                $('#submit-button').prop('disabled', true).text('Please wait...');
                this.submit(); // allow submission
            }
        });
    });
</script>


<!-- validate number and name input fields -->
<script>
	$("input[type='number'], .number").on("input", function () {
	    this.value = this.value.replace(/[^0-9]/g, '');
	     if (this.value.length > 10) {
	      this.value = this.value.slice(0, 10); 
	  }
	});
    $("#email_otp,#mobile_otp").on("input", function () {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 6) {
            this.value = this.value.substring(0, 6);
        }
    });
	$(".alphabet").on("input", function () {
	    this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
	});	
</script>

<script>
	$(document).ready(function() {
		$(document).on("contextmenu", function(e) {
			e.preventDefault();
		});
		$("#regEmail, #regMobile").on("copy cut paste", function(e) {
			e.preventDefault();
		});
		$(document).keydown(function(e) {
			if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'x' || e.key === 'v')) {
				e.preventDefault();
			}
		});

		function validatePassword(){
			var password = $('#password').val();
			var confirmPassword = $('#cpassword').val();

			if(password != confirmPassword){
				$('.password-error').text("Password Do Not Match!");
				$('#submit-button').css('cursor','no-drop').attr('title','Password Do not Match!').prop('disabled', true);
			} else {
				$('.password-error').text("");
				$('#submit-button').prop('disabled', false).css('cursor','pointer').removeAttr('title');
			}	
		}	

		$("#email").on("keyup", function() {
			validateEmail();
		});
		
		$('#cpassword').on('keyup', function(){
			validatePassword();
		});  
	});		
</script>

<script>
    function sendEmailOtp() {
        const email = $('#email').val();
        if (email === '') {
            alert('Please enter email');
            return;
        }
        $("#sendEmailOtpButton").prop("disabled", true).css('cursor', 'no-drop').text('Sending OTP...');
        $.ajax({
            url: '{{ url('/send-otp') }}',
            method: 'POST',
            data: {
                email: email,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if(response.success === true){
                    $('#emailOtpContainer').show();
                    $("#sendEmailOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Email Otp Again');
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });                   
                }else{
                    iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                    $("#sendEmailOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Email Otp Again2');
                }
               
            },
            error: function () {
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                    position: 'topRight',
                    timeout: 3000,
                });
                $("#sendEmailOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Email Otp');
            }
        });
    }

    function verifyEmailOtp() {
        let otp = $('#email_otp').val();
        if (!otp) return alert('Please enter OTP');
        $("#emailOtpVerifyButton").prop("disabled", true).css('cursor', 'no-drop').text('Verifying OTP...');        
       $.ajax({
            url: '{{ url('/verify-otp') }}',
            method: 'POST',
            data: {
                otp: otp,
                email: $('#email').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if(response.status === true){
                    $('#emailOtpContainer').hide();
                    $('#sendEmailOtpContainer').hide();
                    $('#email').attr('readonly', true);
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                }else{
                     $("#emailOtpVerifyButton").prop("disabled", false).css('cursor', 'pointer').text('Verify OTP');   
                    iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                }
               
            },
            error: function () {
                iziToast.error({
                    title: 'Error',
                    message: response.message,
                    position: 'topRight',
                    timeout: 3000,
                });
                 $("#emailOtpVerifyButton").prop("disabled", false).css('cursor', 'pointer').text('Verify OTP');   
            }
        });
    }

    function sendMobileOtp() {
        const mobile = $('#mobile').val();
        if (mobile === '') {
            alert('Please enter mobile number');
            return;
        }
        $("#sendMobileOtpButton").prop("disabled", true).css('cursor', 'no-drop').text('Sending OTP...');
        $.ajax({
            url: '{{ url('send-whatsapp-otp') }}',
            method: 'POST',
            data: {
                mobile: mobile,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if(response.status === true){
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                    $('#mobileOtpContainer').show();                     
                    $("#sendMobileOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Mobile OTP Again');
                }else{
                     iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                    $('#mobileOtpContainer').hide();  
                    $("#sendMobileOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Mobile OTP');
                }
            },
            error: function () {
                alert('Failed to send mobile OTP');
            }
        });
    } 

    function verifyMobileOtp() {
        let otp = $('#mobile_otp').val();
        if (!otp) return alert('Please enter OTP');
        
        $.ajax({
            url: '{{ url('verify-whatsapp-otp') }}',
            method: 'POST',
            data: {
                mobile: $('#mobile').val(),
                otp: otp,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if(response.status === true){
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                    $('#mobile').attr('readonly', true);
                    $('#mobileOtpContainer').hide();     
                     $('#sendMobileOtpButton').hide();               
                }else{
                     iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                    $('#mobileOtpContainer').show();  
                     $("#sendMobileOtpButton").prop("disabled", false).css('cursor', 'pointer').text('Send Mobile OTP Again');                    
                }
            },
            error: function () {
                alert('Failed to send mobile OTP');
            }
        });
    }
</script>

@endpush