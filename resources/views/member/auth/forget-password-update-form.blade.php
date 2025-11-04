@extends('front.layout.app')
@section('content')
<br><br>
<div class="container">
	<div class="row">
		<div class="col-12 col-lg-5">
			<div class="register-image-block" style="height: 93%;">
				<img src="{{ asset('app/courses/2025/Feb/1740647495.jpg') }}"  alt="{{ asset('app/courses/2025/Feb/1740647495.jpg') }}">
			</div>
		</div>
		<div class="col-12 col-lg-7">
			<div class="registeration-form-member ">
				<div id="registration-form" class="form-container active">
					<h2>Update Your Password</h2>
					<form action="{{ route('postresetPassword') }}" method="post">
						@csrf
                  <input type="hidden" name="token" value="{{ $token }}" >
						<div>              
							<input type="email" name="email" value="{{ $email ?? '' }}" readonly required>                       
						</div>
						<div>
							<input type="password" name="password" id="password" placeholder="Enter Your Password" autocomplete="one-time-code" required>
						</div>
						<div>
							<input type="password" name="cpassword" id="cpassword" placeholder="Enter Confirm Password" autocomplete="one-time-code" required>
							<span id="password_error"  class="text-danger" ></span>
						</div>
						<button id="submit_button" type="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>
@endsection
@push('js')
<script>
	$(document).ready(function() {
	    let password = $("#password");
	    let cpassword = $("#cpassword");
	    var button = $('#submit_button');
	    
	    cpassword.on('input', function(){
	        if(password.val() != cpassword.val()){
	            $('#password_error').text("Password Do Not Match");
	            button.prop('disabled', true);
	        } else {
	            $('#password_error').text("");
	            button.prop('disabled', false);
	        }
	    });
	});
</script>
@endpush