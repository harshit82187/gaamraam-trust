@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .loader-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
        color: white;
    }
    .loader {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #012549;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    .processing{
        font-size: 18px;
        line-height: 26px;
        color: black;
        font-weight: 900;
        font-family: 'Lora', serif;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
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
</style>

@endpush

<div id="paymentLoader" class="loader-overlay d-none"  >
    <div class="loader"></div>
    <p class="processing" >⏳ Processing Payment, Please Wait...</p>
</div>
<div class="card" style="padding:0px !important;">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="mt-3">Add New Member </h3>
	</div>
</div>
<div id="paymentLoader" class="payment-loader-overlay d-none">
	<p class="payment-processing">⏳ Processing Payment, Please Wait...</p>
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
<div class="row">
	<div class="col-12">
		@if(session()->get('error'))
		<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
			{{ session()->get('error') }}
			<button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
			<span class="text-dark" aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@if ($errors->any())
		<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
			<ul>
				@foreach ($errors->all() as $error)
				<li style="font-size:larger;">{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
			<span class="text-dark" aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
</div>

<div class="card">
	<div class="card-body">
		<form id="member-save" action="{{ route('admin.member-save') }}" method="post" enctype="multipart/form-data" class="text-start">
			@csrf                  
			<div class="card">
				<div class="card-body">
					<h5 class="mb-0 page-header-title text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						General information
					</h5>
					<div class="row">						
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="title-color">Full Name <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control alphabet @error('name') is-invalid @enderror" id="name" placeholder="Enter Member Full Name" required>
								@error('name') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phone" class="title-color">Email <span class="text-danger">*</span></label>
								<input class="form-control @error('email') is-invalid @enderror" name="email" type="email" autocomplete="one-time-code" id="email" placeholder="Enter Member Email" required>
								<span id="regEmailError" class="text-danger"></span>
								@error('email') <p style="color:red;">{{ $message }}</p> @enderror
							</div>							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phone" class="title-color">Mobile Number <span class="text-danger">*</span></label>
								<input class="form-control number" name="mobile" type="text" autocomplete="one-time-code" id="mobile" placeholder="Enter Member Mobile Number" required>
								<span id="regMobileError" class="text-danger"></span>
								@error('mobile') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="title-color">Password <span class="text-danger">*</span></label>
								<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="one-time-code" id="password" placeholder="Create Password" required>
								@error('password') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="name" class="title-color">Confirm Password <span class="text-danger">*</span></label>
								<input type="password" name="cpassword" class="form-control" autocomplete="one-time-code" id="cpassword" placeholder="Enter Password Again" required>
							    <span class="password-error text-danger"></span>
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
								<label for="profile_image" class="title-color">Profile Photo </label>
								<input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept=".jpeg,.jpg,.png,.webp">
							</div>
							@error('profile_image') <p style="color:red;">{{ $message }}</p> @enderror
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="attachments" class="title-color">Occupation Photo (You Can Upload Multiple Photo Here)</label>
								<input type="file" name="attachments[]" multiple class="form-control @error('attachments') is-invalid @enderror" accept=".jpeg,.jpg,.png,.webp">
							</div>
							@error('blood_group') <p style="color:red;">{{ $message }}</p> @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>District <span class="text-danger">* </span></label>
							<select class="form-select select2 @error('city') is-invalid @enderror" name="city" id="city" required >
								<option selected disabled>--Select District--</option>
								@php
								$haryana = App\Models\State::where('name', 'Haryana')->first();
								$cities = $haryana ? App\Models\City::where('state_id', $haryana->id)->get() : collect([]);
								@endphp
								@foreach($cities as $city)
								<option value="{{ $city->id }}">{{ $city->name }}</option>
								@endforeach                         
							</select>
							@error('city')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Block <span class="text-danger">* </span></label>
							<select class="form-select select2 @error('block') is-invalid @enderror" name="block" id="block" required >
								<option disabled selected >--Select Block--</option>
							</select>
							@error('block')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="mode" class="title-color">Payment Mode</label>
								<select class="form-select @error('mode') is-invalid @enderror" name="mode" id="mode" required >
									<option disabled selected >--Select Mode--</option>
									<option value="1">Razorpay</option>
									<option value="3">Offline Mode (Bar Code Scan) </option>
								</select>
								@error('mode') <p style="color:red;">{{ $message }}</p> @enderror
							</div>
						</div>
						<div id="qr-code-body" style="display:none;"></div>
						<div id="plan-body" style="display:none;"></div>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	var razorpay_logo = "{{ asset('front/img/faviconn.ico') }}";
	var RAZORPAY_KEY = "{{ config('services.razorpay.key') }}";
	var proccedRoute = "{{ route('proccedd-to-pay') }}";
</script>
<script src="{{ asset('admin/assets/js/member/razorpay.js') }}"></script>
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
	$(document).ready(function() {
	    $('#city, #block').select2();
	    $('#city').on('change', function() {
	        var cityId = $(this).val();
	        var blockSelect = $('#block');
	        blockSelect.find('option:not(:first)').remove();
	        if (cityId) {
	            $.ajax({
	                url: '{{ route("get.blocks") }}',
	                type: 'GET',
	                data: {
	                    city_id: cityId
	                },
	                success: function(data) {
	                    $.each(data, function(index, block) {
	                        blockSelect.append(
	                            $('<option></option>').val(block.id).text(block.name)
	                        );
	                    });
	                    var currentBlockId = '{{ $member->block ?? "" }}';
	                    if (currentBlockId) {
	                        blockSelect.val(currentBlockId).trigger('change');
	                    }
	                },
	                error: function() {
	                    alert('Error fetching blocks. Please try again.');
	                }
	            });
	        }
	    });
	    if ($('#city').val()) {
	        $('#city').trigger('change');
	    }
	});
</script>
<script>
	$(document).ready(function () {
	   const qrBodyHtml = `
	        <div class="row">
	            <div class="col-md-12">
	                <label class="mt-3 fs-5">Please Scan This QRCode And Then Upload Transaction Screenshot <span class="text-danger">*</span></label>
	                <img src="{{ asset('front/images/GammRaamQrCode.PNG') }}" alt="QR Code" class="barcode_img">
	            </div>
	
	            <div class="col-md-6 mt-3">
	                <label>Amount <span class="text-danger">*</span></label>
	                <input type="number" name="donate_amount" id="donate_amount" placeholder="Enter Your Donate Amount" class="form-control" required>
	            </div>
	
	            <div class="col-md-6 mt-3">
	                <label>Attachment <span class="text-danger">*</span></label>
	                <input type="file" name="transaction_attachment" id="transaction_attachment" class="form-control" required accept="image/*">
	            </div>
	        </div>`;
	
	
	    const planBodyHtml = `
	        <div class="col-md-6">
	            <label>Select Membership Type:</label><br>
	            <div class="select-membership d-flex">
	                <input type="radio" name="plan" value="1" checked required >
	                <label id="monthly-membership-label">Monthly Membership (100 Rupees per month)</label><br>
	            </div>
	            <div class="select-membership d-flex">
	                <input type="radio" name="plan" value="2" >
	                <label id="yearly-membership-label">Yearly Membership (1100 Rupees per year)</label>
	            </div>
	        </div>`;
	
	    $('#mode').on('change', function () {
	        const selectedValue = $(this).val();
	
	        if (selectedValue == '3') {
	            $('#qr-code-body').html(qrBodyHtml).show();
	            $('#plan-body').hide().html('');
	        } else if (selectedValue == '1') {
	            $('#plan-body').html(planBodyHtml).show();
	            $('#qr-code-body').hide().html('');
	        } else {
	            // Reset if value is something else
	            $('#qr-code-body').hide().html('');
	            $('#plan-body').hide().html('');
	        }
	    });
	    $('#mode').trigger('change');
	});
</script>

<script>
    $(document).ready(function () {
        $('#member-save').on('submit', function (e) {
            e.preventDefault(); // prevent default submit
            let isValid = true;
            let mode = $('#mode').val();
			console.log("Mode Value is "+mode);

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
                { selector: 'select[name="city"]', name: 'District' },
                { selector: 'select[name="block"]', name: 'Block' },
                { selector: 'select[name="mode"]', name: 'Payment Mode' }
            ];

            fieldsToValidate.forEach(field => {
				const input = $(field.selector);
				if (!input.val()) {
					console.log(`Field: ${field.selector}, Message: ${field.name} is required`);
					showError(input, `${field.name} is required`);
				}
			});
            // Check if passwords match
            const password = $('input[name="password"]').val();
            const cpassword = $('input[name="cpassword"]').val();
            if (password && cpassword && password !== cpassword) {
                showError($('input[name="cpassword"]'), 'Passwords do not match');
            }

            // Conditional validation based on mode
            if (mode == '1') {
                const planSelected = $('input[name="plan"]:checked').val();
                if (!planSelected) {
                    showError($('#plan-body'), 'Please select a membership plan');
                }
            } else if (mode == '3') {
                const amount = $('input[name="donate_amount"]').val();
                const attachment = $('input[name="transaction_attachment"]').val();
                if (!amount) {
                    showError($('input[name="donate_amount"]'), 'Amount is required');
                }
                if (!attachment) {
                    showError($('input[name="transaction_attachment"]'), 'Transaction Attachment is required');
                }
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
	$(".alphabet").on("input", function () {
	    this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
	});
	
</script>

<!-- validate email, mobile and password input fields -->
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

		function validateEmail() {
			let email = $("#email").val().trim();
			console.log("Email :" + email);
			if (email !== "") {
				$.ajax({
					url: "{{ route('validate-email') }}",
					type: "POST",
					data: {
						email: email,
					'_token': $('meta[name="csrf-token"]').attr('content'),
					},
					success: function(response) {

						if (response.status === "error") {
							$("#regEmailError").text(response.message);
							$("#submit-button").prop("disabled", true).css('cursor', 'no-drop');
						} else {
							$("#regEmailError").text("");
							$("#submit-button").prop("disabled", false).css('cursor', 'pointer');
						}
					}
				});
			}
		}

		function validateMobile() {
			let mobile = $("#mobile").val().trim();
			console.log("Mobile: " + mobile);
			if (mobile !== "") {
				$.ajax({
					url: "{{ route('validate-mobile') }}",
					type: "POST",
					data: {
						mobile: mobile,
					'_token': $('meta[name="csrf-token"]').attr('content'),
					},
					success: function(response) {
						console.log(response);                     
						if (response.status === 'error' && response.exists) {
							$("#regMobileError").text(response.message);
							$("#submit-button").prop("disabled", true).css('cursor', 'no-drop');
						} else {
							$("#regMobileError").text("");
							$("#submit-button").prop("disabled", false).css('cursor', 'pointer');
						}
					}
				});
			} else {
				$("#regMobileError").text("Enter a valid mobile number (10-15 digits).");
				$("#submit-button").prop("disabled", true).css('cursor', 'no-drop');
			}
		}

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

		$("#mobile").on("keyup", function() {
			validateMobile();
		});

		$('#cpassword').on('keyup', function(){
			validatePassword();
		});  
	});
		
</script>
@endpush