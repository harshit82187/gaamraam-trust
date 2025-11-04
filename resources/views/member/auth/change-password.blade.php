@extends('member.layouts.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="page-content">
<div class="container-fluid">

	<div class="card">
		<div class="card-body">
			<h3>Change Password</h3>
			<form method="POST" action="{{ route('member.change-password-process')  }}" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Password <span class="text-danger">* </span> </label>
						<input type="text" class="form-control" id="password"  name="password" >
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Confirm Password <span class="text-danger">* </span> </label>
						<input type="password" autocomplete="one-time-code" class="form-control" id="cpassword"  >
						<div class="text-danger" id="confirm-password" ></div>
					</div>
					<div class="col-md-2" style="margin-top: 18px;" >
						<input type="submit" class="btn btn-primary" id="update-button2" value="Update"  >
					</div>
			</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')


<script>
	$(document).ready(function(){
	    $("#cpassword").on('keyup', function(){
	        var cpassword = $(this).val();
	        var password = $('#password').val();
	        console.log("Password COnfirm :",cpassword);
	
	        if(cpassword != password){
	            $("#confirm-password").html("Password Do Not Match!");
	            $("#update-button2").prop('disabled',true);
	        }else{
	            $("#confirm-password").html("");
	            $("#update-button2").prop('disabled',false);
	
	        }          
	    });
	

	});
</script>

@endpush