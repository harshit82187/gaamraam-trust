@extends('institute.layout.app')
@section('content')
@push('css')
@endpush
<div class="card">
	<div class="card-body">
		<h1>My Profile</h1>
		<div class="text-center py-2 institue-profiless">
			@if($institute->profile_image)
			<img src="{{ asset($institute->profile_image) }}" height="100px" width="100px" style="padding: 5px; border-radius: 50px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
			@else
			<img src="{{ asset('front/images/no-image.jpg') }}" height="60px" width="60px" style="padding: 5px; border-radius: 50px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
			@endif
		</div>
		<form id="profile" action="{{ route('institute.profile') }}" enctype="multipart/form-data" method="POST">
			<input type="hidden" name="form_type" value="profile_update">
			@csrf
			<div class="row">
				<div class="form-group col-sm-6">
					<label>New Image</label>
					<input type="file" class="form-control" name="profile_image" accept=".jpeg,.jpg,.png,image/jpeg,image/jpg,image/png">
					@error('image')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group col-sm-6">
					<label>Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" value="{{ old('name', $institute->name) }}" name="name">
					@error('name')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group col-sm-6">
					<label>Email <span class="text-danger">*</span></label>
					<input type="email" class="form-control" value="{{ old('email', $institute->email) }}" name="email">
					@error('email')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group col-sm-6">
					<label>Mobile No <span class="text-danger">*</span></label>
					<input type="text" class="form-control" value="{{ old('mobile_no', $institute->mobile_no) }}" name="mobile_no">
					@error('mobile_no')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
			</div>
			<div class="row py-2">
				<div class="col-12">
					<button id="update-button" class="btn btn-primary">Update Profile</button>
				</div>
			</div>
		</form>
		<div class="row py-2">
			<form id="profile" action="{{ route('institute.profile') }}" method="POST">
				<input type="hidden" name="form_type" value="password_update">
				@csrf
				<h2>Password Change (If You Want)</h2>
				<div class="row">

					<div class="form-group col-sm-6">
						<label>Password</label>
						<input type="password" class="form-control" name="password">
						@error('password')
						<small class="text-danger">{{ $message }}</small>
						@enderror
					</div>
					<div class="form-group col-sm-6">
						<label>Confirm Password</label>
						<input type="password" class="form-control" name="password_confirmation">
						@error('password_confirmation')
						<small class="text-danger">{{ $message }}</small>
						@enderror
					</div>

				</div>
				<div class="row">
					<div class="col-sm-6">
						<button id="update-button2" class="btn btn-primary">Update Password </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	$(document).on('submit', 'form', function(e) {
		let btn = $(this).find('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
			.prop('disabled', true)
			.css('cursor', 'not-allowed');
	});
</script>

@endpush