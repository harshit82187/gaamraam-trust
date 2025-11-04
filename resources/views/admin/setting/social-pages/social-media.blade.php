@extends('admin.layout.app')
@section('content')
@include('admin.setting.social-pages.menu-bar')
<div class="card">
	<div class="card-header">
		<div class="mail-menu">
			<div style="display: flex; align-items:center; gap:10px; cursor:pointer;">
				<img src="{{ asset('front/images/social media.png') }}" style=" width:28px; ">
				<h1>Social media</h1>
			</div>
		</div>
	</div>
</div>
<div class="card-maintenance">
	<div class="card-body ">
		<form id="social-media" action="{{ route('admin.social-pages.social-media') }}" method="POST" enctype="multipart/form-data">
			@csrf                            
			<div class="row">
				<div class="col-12">
					<label style="color: black;margin-left:1%;">Facebook <span class="text-danger">*</span></label>
					<input type="text" class="form-control " required name="facebook" value="{{ $socialMediaConfig['facebook'] ?? '' }}">								
				</div>
				<div class="col-12" style="margin-top:2%">
					<label style="color: black;margin-left:1%;">Instagram <span class="text-danger">*</span></label>
					<input type="text" class="form-control " required name="instagram" value="{{ $socialMediaConfig['instagram'] ?? '' }}">								
				</div>
				<div class="col-12" style="margin-top:2%">
					<label style="color: black;margin-left:1%;">Youtube <span class="text-danger">*</span></label>
					<input type="text" class="form-control " required name="youtube" value="{{ $socialMediaConfig['youtube'] ?? '' }}">								
				</div>
			</div>
			<div class="row" style="margin-top: 1%;">
				<div class="col-2">
					<button type="submit" class="btn btn-primary" >Update</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@push('js')
<script>
    $(document).on('submit', '#social-media', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>
@endpush