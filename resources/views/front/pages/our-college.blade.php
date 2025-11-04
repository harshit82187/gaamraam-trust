@extends('front.layout.app')
@section('content')
@php $formType = request()->get('form'); @endphp
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/part.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>@lang('messages.our_associate_institution')</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">@lang('messages.home')</a></li>
					<li><a href="{{ url()->current() }}">@lang('messages.institutions')</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- login member section -->
<section class="py-5">
	<div class="container">
		<div class="row reverse-row-div">
			<div class="col-lg-6 d-flex py-2">
				<div class="login-section">
					<h4 class="py-3 text-center">@lang('messages.partner_with_gaamraam_transform_education_at_zero_cost_!')</h4>
					<p>@lang('messages.gaamraam_revolutionizing_education_by_bringing_free_high_quality_coaching_for_upsc_ssc_and_other_competitive_exams_directly_to_student_hometowns_by_partnering_with_us_your_institution_can_become_a_center_of_excellence_offering_live_classes_from_mukherjee_nagars_top_educators_all_without_financial_commitment')</p>
					
				</div>
			</div>
			<div class="col-lg-6 py-2">
				<div class="donate-form member-signup">
					<div class="donation-heading text-center">
						<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="Logo">
						<h2 class="mt-2">@if ($formType == 'forgot') Forgot Password	@else	Institute Login	@endif	</h2>
					</div>

					{{-- Login Form --}}
					<div class="tab-pane" id="login" role="tabpanel" style="{{ ($formType == 'forgot') ? 'display:none;' : 'display:block;' }}">
						<form id="institute-login-form" method="POST">
							@csrf
							<div class="form-group">
								<label for="login-email">Email <span class="text-danger">*</span></label>
								<input type="email" name="email" class="form-control" id="login-email" required>
							</div>
							<div class="form-group">
								<label for="login-password">Password <span class="text-danger">*</span></label>
								<input type="password" name="password" class="form-control" id="login-password" required>
							</div>
							<button type="submit" id="institute-login-button" class="btnn-donate">Login</button>
						</form>
						<p class="text-center mt-2">
							<a href="{{ url('our-institutions?form=forgot') }}" id="forgot-password-link">Forgot Password?</a>
						</p>
					</div>

					{{-- Forgot Password Form --}}
					<div class="tab-pane" role="tabpanel" style="{{ ($formType == 'forgot') ? 'display:block;' : 'display:none;' }}">
						<div id="forgot-password-form">
							<form id="institute-forget-password-submit-form" method="POST">
								@csrf
								<span id="success-message" ></span>
								<div class="form-group">
									<label for="forgot-email">Enter Your Email</label>
									<input type="email" name="email" class="form-control" id="forgot-email" required>
								</div>
								<button type="submit" id="institute-forget-password-submit-form-button" class="btnn-donate">Reset Password</button>
							</form>
							<p class="text-center mt-2">
								<a href="{{ url('our-institutions?form=login') }}">Back To Login</a>
							</p>
						</div>
					</div>


					{{-- Forgot Password Update Form --}}
					<div class="tab-pane" role="tabpanel" style="{{ ($formType == 'forgot-password-update') ? 'display:block;' : 'display:none;' }}">
						<div id="forgot-password-form">
							<form id="institute-forget-password-submit-form" method="POST">
								@csrf
								<span id="success-message" ></span>
								<div class="form-group">
									<label for="forgot-email">Enter Your Email</label>
									<input type="email" name="email" class="form-control" id="forgot-email" required>
								</div>
								<button type="submit" id="institute-forget-password-submit-form-button" class="btnn-donate">Reset Password</button>
							</form>
							<p class="text-center mt-2">
								<a href="{{ url('our-institutions?form=login') }}">Back To Login</a>
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
<section class="py-5 bg-very-light-gray">
	<div class="container">
		<div class="row">
			<div class="section-heading">
				<h2 class="member-all">@lang('messages.shared_responsibilities')</h2>
					<p>@lang('messages.what_we_seek_and_what_we_offer')</p>
			</div>
			<div class="requirment-content">
				<div class="box institution">
					<h2>@lang('messages.whats_required_from_your_institution')</h2>
					<ul>
						<li>@lang('messages.provide_classrooms_utilize_idle_space_for_competitive_exam_coaching') </li>
						<li>@lang('messages.appoint_a_class_coordinator_manage_attendance_and_discipline')</li>
						<li>@lang('messages.equip_lcd_or_projection_screens_enable_interactive_learning')</li>
					</ul>
				</div>
				<div class="box commitment">
					<h2>@lang('messages.gaamraams_commitment')</h2>
					<ul>
						<li>@lang('messages.hire_and_pay_faculty_including_live_sessions_from_mukherjee_nagar')</li>
						<li>@lang('messages.provide_study_materials_e_notes_and_test_series_for_all_major_exams')</li>
						<li>@lang('messages.monitor_student_progress_regular_feedback_for_continuous_improvement')</li>
						<li>@lang('messages.promote_your_institution_increase_visibility_and_student_enrollment')</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="py-5">
	<div class="container">
		<div class="row py-5">
			<div class="section-heading">
				<h2 class="member-all">@lang('messages.our_associate_institution')</h2>
			</div>
			<div class="process-wrapper">
				<!-- remove this class process-content-wrapper -->
				<div class="">
					<div class="row mt-n1-9">
						@isset($colleges)
						@foreach($colleges as $college)
						<div class="col-md-6 col-lg-4 mt-1-9">
							<div class="process-content-teacher">
								<div class="student-image-block py-2">
									<a href="">
									<img src="{{ asset($college->logo) }}" alt="{{ asset($college->logo) }}">
									</a>
								</div>
								<h3 class="h4">{{ $college->name ?? '' }}</h3>
								<p class="mb-0 college-content">
									{{ Illuminate\Support\Str::limit(strip_tags($college->description, 15)) }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ strip_tags($college->description) }}"></i>
								</p>
							</div>
						</div>
						@endforeach
						@endisset
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('js')
<script>
	$(document).ready(function() {
		$("#institute-login-form").on("submit", function(e) {
			e.preventDefault(); 
	
			let btn = $("#institute-login-button");
			btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
			   .prop('disabled', true)
			   .css('cursor', 'no-drop');
	
			$.ajax({
				url: "{{ route('institute-login') }}",
				type: "POST",
				data: $(this).serialize(),
				dataType: "json",
				success: function(response) {
					if (response.status === "success") {
						iziToast.info({
							title: 'Success',
							message: response.message,
							position: 'topRight',
							timeout: 2000
						});
						setTimeout(function() {
							window.location.href = response.redirect_url;
						}, 2000);
					} else {
						iziToast.error({
							title: 'Error',
							message: response.message,
							position: 'topRight',
							timeout: 3000
						});
						btn.html('Login').prop('disabled', false).css('cursor', 'pointer');
					}
				},
				error: function(xhr) {
					let errorMessage = 'Something went wrong!';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMessage = xhr.responseJSON.message;
					}
					iziToast.error({
						title: 'Error',
						message: errorMessage,
						position: 'topRight',
						timeout: 3000
					});
					btn.html('Login').prop('disabled', false).css('cursor', 'pointer');
				}
			});
		});
		$("#institute-forget-password-submit-form").on("submit", function(e) {
			e.preventDefault(); 
	
			let btn = $("#institute-forget-password-submit-form-button");
			btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
			   .prop('disabled', true)
			   .css('cursor', 'no-drop');
	
			$.ajax({
				url: "{{ route('institute-forget-password-submit-form') }}",
				type: "POST",
				data: $(this).serialize(),
				dataType: "json",
				success: function(response) {
					if (response.status === "success") {
						iziToast.info({
							title: 'Success',
							message: response.message,
							position: 'topRight',
							timeout: 2000
						});
						$('#success-message').html(response.message).css({ color: 'green', fontSize: '18px' });
						btn.html('Reset Password').prop('disabled', false).css('cursor', 'pointer');
						$('#institute-forget-password-submit-form')[0].reset();
					} else {
						iziToast.error({
							title: 'Error',
							message: response.message,
							position: 'topRight',
							timeout: 3000
						});
						btn.html('Reset Password').prop('disabled', false).css('cursor', 'pointer');

					}
				},
				error: function(xhr) {
					let errorMessage = 'Something went wrong!';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMessage = xhr.responseJSON.message;
					}
					iziToast.error({
						title: 'Error',
						message: errorMessage,
						position: 'topRight',
						timeout: 3000
					});
					btn.html('Reset Password').prop('disabled', false).css('cursor', 'pointer');
				}
			});
		});
	});
</script>
	
@endpush