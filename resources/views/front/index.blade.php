@extends('front.layout.app')
@section('content')

<section class="top-position1 py-0">
	<div class="container-fluid px-0">
		<div class="slider-fade1 owl-carousel owl-theme w-100">
			<div
				class="item bg-img cover-background pt-6 pb-10 pt-sm-6 pb-sm-14 py-md-16 py-lg-20 py-xxl-24 left-overlay-dark"
				data-overlay-dark="8"
				data-background="{{ asset('front/images/IAS.jpg') }}">
				<div class="container pt-6 pt-md-0">
					<div class="row align-items-center">
						<div
							class="col-md-10 col-lg-8 col-xl-7 mb-1-9 mb-lg-0 py-6 position-relative">
							<span class="h5 text-secondary">@lang('messages.in_every_district_of_haryana')</span>
							<h1 class="display-1 font-weight-800 mb-1 title text-white">
								@lang('messages.free_coaching')
							</h1>
							<h3
								class="font-weight-700 mb-2-5 title text-white display-15">
								@lang('messages.by_gaamraam_charitable_trust')
							</h3>
							<!-- <li class="d-none d-xl-inline-block"> -->
							<a href="{{route('student.login')}}" class="become-memb butn md text-white my-2 "><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">@lang('messages.student_login')</span><i class="fas fa-plus-circle icon-arrow after"></i></a>
						</div>
						<div class="col-md-4 col-lg-4 col-xl-4">
							<div class="faq-form enrol-form d-none">
								<h2 class="text-primary">@lang('messages.sign_up')</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div
				class="item bg-img cover-background pt-6 pb-10 pt-sm-6 pb-sm-14 py-md-16 py-lg-20 py-xxl-24 left-overlay-dark"
				data-overlay-dark="8"
				data-background="{{ asset('front/images/IPS.jpg') }}">
				<div class="container pt-6 pt-md-0">
					<div class="row align-items-center">
						<div
							class="col-md-10 col-lg-8 col-xl-7 mb-1-9 mb-lg-0 py-6 position-relative">
							<span class="h5 text-secondary">@lang('messages.in_every_district_of_haryana')</span>
							<h2 class="display-1 font-weight-800 mb-1 title text-white">
								@lang('messages.free_coaching')
							</h2>
							<h3
								class="font-weight-700 mb-2-5 title text-white display-15">
								@lang('messages.by_gaamraam_charitable_trust')
							</h3>
							<!-- <li class="d-none d-xl-inline-block"> -->
							<a href="{{route('student.login')}}" class="become-memb butn md text-white my-2"><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">@lang('messages.student_login')</span><i class="fas fa-plus-circle icon-arrow after"></i></a>
						</div>
						<div class="col-md-4 col-lg-4 col-xl-4">
							<div class="faq-form enrol-form d-none">
								<h2 class="text-primary">Become a Student</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div
				class="item bg-img cover-background pt-6 pb-10 pt-sm-6 pb-sm-14 py-md-16 py-lg-20 py-xxl-24 left-overlay-dark"
				data-overlay-dark="8"
				data-background="{{ asset('front/images/SDM.jpg') }}">
				<div class="container pt-6 pt-md-0">
					<div class="row align-items-center">
						<div
							class="col-md-10 col-lg-8 col-xl-7 mb-1-9 mb-lg-0 py-6 position-relative">
							<span class="h5 text-secondary">@lang('messages.in_every_district_of_haryana')</span>
							<h2 class="display-1 font-weight-800 mb-1 title text-white">
								@lang('messages.free_coaching')
							</h2>
							<h3
								class="font-weight-700 mb-2-5 title text-white display-15">
								@lang('messages.by_gaamraam_charitable_trust')
							</h3>
							<!-- <li class="d-none d-xl-inline-block"> -->
							<a href="{{route('student.login')}}" class="become-memb butn md text-white my-2"><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">@lang('messages.student_login')</span><i class="fas fa-plus-circle icon-arrow after"></i></a>
						</div>
						<div class="col-md-4 col-lg-4 col-xl-4">
							<div class="faq-form enrol-form d-none">
								<h2 class="text-primary">@lang('messages.sign_up')</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="faq-form enrol-form">
			<h2 class="mb-2 text-primary">@lang('messages.sing_up_for_free_coaching')</h2>
			<form id="contact-us" class="contact " action="{{ route('student-register') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="quform-elements">
					<div class="row">
						<!-- Begin Text input element -->
						<div class="col-md-12">
							<div class="quform-element form-group">
								<label for="name">@lang('messages.your_name')<span class="quform-required">*</span></label>
								<div class="quform-input">
									<input class="form-control alphabet" id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="@lang('messages.enter_your_name')" />
								</div>
								@error('name')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-12">
							<div class="quform-element form-group mb-0">
								<label for="email">@lang('messages.your_email') <span class="quform-required">*</span></label>
								<div class="quform-input form-group mb-0">
									<input class="form-control" id="email" type="email" required value="{{ old('email') }}" name="email" placeholder="@lang('messages.enter_your_mail')" />
								</div>
								<span id="emailError"></span>
							</div>
						</div>

						<div class="col-md-12">
							<div class="quform-element form-group">
								<label for="phone">@lang('messages.contact_number')<span class="quform-required">*</span></label>
								<div class="quform-input">
									<input class="form-control number" type="text" required value="{{ old('phone') }}" name="phone" placeholder="@lang('messages.enter_your_whatsapp_number')" />
									
								</div>
								@error('phone')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="col-md-12">
							<div class="quform-element form-group">
								<label for="verifyMethod">Select Verification Method:</label>
								<select id="verifyMethod" class="form-control mb-2">
									<option value="email" selected>Email</option>
									<option value="whatsapp">WhatsApp</option>
								</select>
								
								<div class="d-flex align-items-center">
									<div id="emailOption" class="verification-option">
										<button type="button" class="send-otp-btn my-2 btn btn-primary" id="sendEmailOtpBtn">@lang('messages.get_otp_on_email')</button>
										<br><span id="regEmailError" class="text-danger"></span>
									</div>
									
									<div id="whatsappOption" class="verification-option" style="display: none;">
										<a href="javascript:void(0);" class="send-otp-btn my-2 btn btn-primary" id="sendOtpBtn">@lang('messages.get_otp_on_whatsapp')</a>
										<br><span id="sendOtpError" class="text-danger" style="font-size:20px;"></span>
									</div>
								</div>
							</div>
						</div>



						<div class="col-md-12 d-none" id="otpSection">
							<div class="quform-element form-group">
								<label for="otp">@lang('messages.enter_otp') <span class="quform-required">*</span></label>
								<div class="quform-input form-group mb-0">
									<input class="form-control otp-number" id="emailOtp" type="text" name="otp" placeholder="@lang('messages.enter_otp_here')" />
									<button type="button" class="btn btn-success my-2" id="verifyEmailOtpBtn">@lang('messages.verify_otp')</button>
								</div>
								<span id="otpError"></span>
							</div>
						</div>

						<div class="col-md-12 d-none" id="whatsappotpSection">
							<div class="quform-element form-group">
								<label for="otp">Enter OTP <span class="quform-required">*</span></label>
								<div class="quform-input form-group mb-0">
									<input class="form-control otp-number" id="whatsappOtp" type="text" name="whatsappOtp" placeholder="Enter OTP here" />
									<a href="javascript:void(0);" class="btn btn-success my-2" id="whatsappVerifyOtpBtn">@lang('messages.verify_otp')</a>
								</div>
								
							</div>
						</div>
						<span id="whatsappotpError" style="font-size:20px;"></span>

						<div class="col-md-6">
							<div class="quform-element form-group">
								<label for="phone">@lang('messages.password')<span class="quform-required">*</span></label>
								<div class="quform-input">
									<input class="form-control " type="password" id="password" autocomplete="one-time-code" required value="{{ old('password') }}" name="password" placeholder="@lang('messages.create_your_password')" />
								</div>
								@error('password')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="col-md-6">
							<div class="quform-element form-group">
								<label for="phone">@lang('messages.confirm_password')<span class="quform-required">*</span></label>
								<div class="quform-input">
									<input class="form-control" type="password" id="cpassword" autocomplete="one-time-code" required value="{{ old('password') }}" name="password" placeholder="@lang('messages.confirm_password')" />
									<span id="password_error" class="text-danger"></span>
								</div>
								@error('password')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>




						<input type="hidden" value="UPSC" name="course">

						<!-- <div class="col-md-12">
							<div class="quform-element form-group course-custom-select">
								<label for="course">@lang('messages.select_course_applying_for')<span class="quform-required">*</span></label>
								<div class="quform-input">
									<select class="form-control" name="course" required>
										<option value="">@lang('messages.select_course_applying_for')</option>
										<option value="UPSC">@lang('messages.upsc')</option>
										<option value="SSC">@lang('messages.ssc')</option>
									</select>
									<i class="fas fa-chevron-down"></i>
								</div>
								@error('course')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div> -->

						<div class="g-recaptcha mt-3" data-sitekey="6LcdiiIrAAAAAM95DdpLGBA57sVf2XZ-B1Ot4_Kw"></div>
						<span id="captchaError" style="font-size: 20px;" class="text-danger"></span>

						<div class="col-md-12 mt-2" id="enrollNowWrapper">
							<div class="quform-submit-inner">
								<button class="butn secondary" id="enrool-now-button" type="submit">
									<i class="far fa-paper-plane icon-arrow before"></i>
									<span class="label">@lang('messages.sign_up')</span>
									<i class="far fa-paper-plane icon-arrow after"></i>
								</button>
							</div>
							<div class="quform-loading-wrap text-start">
								<span class="quform-loading"></span>
							</div>
						</div>
						<!-- End Submit button -->
					</div>
				</div>
			</form>
		</div>
	</div>
	<div
		class="triangle-shape top-15 right-10 z-index-9 d-none d-md-block"></div>
	<div
		class="square-shape top-25 left-5 z-index-9 d-none d-xl-block"></div>
	<div class="shape-five z-index-9 right-10 bottom-15"></div>
</section>
<!-- INFORMATION
	================================================== -->
<section class="p-0 overflow-visible service-block d-none">
	<div class="container">
		<div class="row mt-n1-9">
			<div class="col-md-6 col-lg-6 col-xl-3 mt-3 mt-sm-4">
				<div class="card card-style3 h-100">
					<div class="card-body px-1-9 py-2-3">
						<div class="mb-3 d-flex align-items-center flex-column justify-content-center gap-3">
							<div class="card-icon">
								@lang('messages.steps_1')
							</div>
							<h4 class="mb-0 text-center">@lang('messages.sign_up_&_get_started')</h4>
						</div>
						<div class="step-card-para text-center">
							<p class="mb-3">
								@lang('messages.you_are_in_the_right_place_for_free_upsc_&_ssc_coaching_!') </p>

							<a href="{{ route('step-for-enroll') }}" class="butn-style1 secondary">@lang('messages.view_more') +</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3 mt-3">
				<div class="card card-style3 h-100">
					<div class="card-body px-1-9 py-2-3">
						<div class="mb-3 d-flex align-items-center flex-column justify-content-center gap-3">
							<div class="card-icon">
								@lang('messages.step_2')
							</div>
							<h4 class="mb-0 text-center">@lang('messages.upload_&_verify_your_documents') </h4>
						</div>
						<div class="step-card-para text-center">
							<p class="mb-3">
								@lang('messages.after_completing_the_signup_click_on_student_login_at_the_top_of_the_website_use_your_registered_email_id_and_password_to_log_in') </p>
							<a href="{{ route('step-for-enroll') }}" class="butn-style1 secondary">@lang('messages.view_more') +</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3 mt-3">
				<div class="card card-style3 h-100">
					<div class="card-body px-1-9 py-2-3">
						<div class="mb-3 d-flex align-items-center flex-column justify-content-center gap-3">
							<div class="card-icon">
								@lang('messages.step_3')
							</div>
							<h4 class="mb-0 text-center">@lang('messages.aptitude_test_&_institution_selection') </h4>
						</div>
						<div class="step-card-para text-center">
							<p class="mb-3">
								@lang('messages.students_who_pass_document_verification_will_proceed_to_the_aptitude_test_this_test_will_assess_problem_solving_and_analytical_abilities_and_determine_student_rankings')
							</p>
							<a href="{{ route('step-for-enroll') }}" class="butn-style1 secondary">@lang('messages.view_more') +</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-xl-3 mt-3">
				<div class="card card-style3 h-100">
					<div class="card-body px-1-9 py-2-3">
						<div class="mb-3 d-flex align-items-center flex-column justify-content-center gap-3">
							<div class="card-icon">
								@lang('messages.step_4')
							</div>
							<h4 class="mb-0 text-center">@lang('messages.attend_physical_classes')</h4>
						</div>
						<div class="step-card-para text-center">
							<p class="mb-3">
								@lang('messages.students_who_qualify_will_receive_their_official_student_i_card_which_grants_access_to_physical_classes_at_their') </p>
							<a href="{{ route('step-for-enroll') }}" class="butn-style1 secondary">@lang('messages.view_more') +</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<section class="aboutus-style-02">
	<div class="container">
		<div class="row align-items-center mt-n1-9">

			<!-- <div class="col-lg-6 col-xl-5 mt-1-9"> -->

			<h2 class="h1 mb-1-6 text-primary text-center">No exams, No travel, No fees</h2>
			<p class="text-center">Just free quality education delivered to your screen.</p>
			<p class="text-center">Sign up now and take the first step toward your future!</p>
			<h6 class=" text-center"><a href="{{ route('step-for-enroll') }}" class="butn-style1 secondary">@lang('messages.view_more') +</a></h6>

		</div>
		<div class="shape20">
			<img src="https://www.gaamraam.ngo/front/img/bg/bg-02.jpg" alt="...">
		</div>
		<div class="shape18">
			<img src="https://www.gaamraam.ngo/front/img/bg/bg-01.jpg" alt="...">
		</div>
		<div class="shape21">
			<img src="https://www.gaamraam.ngo/front/img/bg/bg-03.jpg" alt="...">
		</div>
	</div>
</section>




<!-- ABOUTUS
	================================================== -->
<section class="aboutus-style-01 position-relative py-5">
	<div class="container pt-lg-4">
		<div class="row align-items-baseline mt-n1-9">
			<div class="col-md-12 col-lg-6 mt-1-9 order-2 order-lg-1">
				<div class="position-relative">
					<div class="sticky-class">
						<div class="position-relative">

							<div class="image-hover">
								<img
									src="{{ asset('front/images/ngo.jpeg') }}"
									alt="..."
									class="position-relative z-index-1" />
							</div>
							<!-- <img src="images/about-02.jpg" alt="..." class="img-2 d-none d-xl-block"> -->
							<img
								src="{{ asset('front/images/bg-07.png') }}"
								class="bg-shape1  d-sm-block"
								alt="..." />

						</div>
						<div class="d-sm-block">
							<div class="about-text">
								<p>@lang('messages.new_batch_startin_coming_soon')
									<!-- <div class="about-counter">
									<span class="countup">30</span> th
								</div> -->
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 mt-1-9 order-2 order-lg-1">
				<div class="section-heading text-start mb-2">
					<span class="sub-title">@lang('messages.welcome')!</span>
				</div>
				<h2 class="font-weight-800 h1 mb-1-9 text-primary">
					@lang('messages.why_free_coaching_matters')
				</h2>
				<blockquote>
					@lang('messages.at_gaamraam_trust_we_believe_that_every_child_in_haryana_is_family_and_in_a_family_education_should_never_be_a_luxury_reserved_for_a_few')
				</blockquote>
				<blockquote>
					@lang('messages.but_the_reality_is_harsh_many_bright_students_are_held_back_by_things_they_cannot_control_money_problems_social_pressures_or_simply_being_far_away_from_big_coaching_hubs_like_delhi')
				</blockquote>

				<blockquote>
					<h5> @lang('messages.removing_every_barrier_in_the_path_of_education')</h5>
					@lang('messages.we_are_here_to_change_that_because')
					<ul>
						<li>@lang('messages.coaching_fees_are_sky_high_and_not_everyone_can_afford_them')</li>
						<li>@lang('messages.many_talented_girls_cannot_leave_home_to_study_in_far_off_cities')</li>
						<li>@lang('messages.rural_students_do_not_get_access_to_delhi_level_teachers_and_guidance')</li>
					</ul>
					<p>@lang('messages.thats_why_gaamraam_trust_offers_completely_free_upsc_and_ssc_coaching_across_haryana_bringing_the_best_to_your_doorstep_no_matter_who_you_are_or_where_you_re_from')</p>
				</blockquote>

				<div class="show-more-ngo" id="show-content" style="display: none;">

					<blockquote>
						<h5>@lang('messages.your_talent_your_chance_your_choice')</h5>
						@lang('messages.we_dont_believe_money_should_decide_who_gets_ahead')
						<p>@lang('messages.so_students_who_do_well_in_our_aptitude_test_get_first_priority_in_choosing_their_preferred_coaching_institutions_without_paying_a_single_rupee')</p>
						<p>@lang('messages.its_not_about_where_you_are_from_its_about_what_you_are_capable_of')</p>
					</blockquote>
					<blockquote>
						<h5>@lang('messages.equal_opportunities_real_change')</h5>
						@lang('messages.no_one_should_miss_out_on_their_dreams_because_of_financial_or_social_limits_with_gaamraam_education_reaches_every_corner_every_child_every_dream')
					</blockquote>
					<blockquote>@lang('messages.free_coaching_isnt_a_favour_its_our_commitment_to_believe_in_our_youth_and_to_invest_in_the_bright_future_of_haryana_and_india')

					</blockquote>
				</div>
				<button class="show-more-btn mt-3" id="view-toggle" onclick="togglecontent()">@lang('messages.see_more')</button>

				<div class="dotted-seprator pt-1-9 mt-1-9"></div>

			</div>
		</div>
		<div class="shape18">
			<img src="{{ asset('front/images/bg-01.jpg') }}" alt="..." />
		</div>
		<div class="shape20">
			<img src="{{ asset('front/images/bg-02.jpg') }}" alt="..." />
		</div>
	</div>
</section>

<!-- ONLINE COURSES
	================================================== -->

<section class="aboutus-style-01 position-relative bg-very-light-gray py-3">
	<div class="container">
		<div class="section-heading">
			<h2 class="h1 mb-0">@lang('messages.free_courses')</h2>
		</div>
		<div class="row g-xxl-5 mt-n2-6 justify-content-center">
			@if(isset($courses))
			@foreach($courses as $course)
			<div class="col-md-6 col-xl-4 mt-3">
				<div class="card card-style1 p-0 h-100">
					<div class="card-img rounded-0">
						<div class="image-hover">
							<img class="rounded-top" src="{{ asset($course->image) }}" alt="{{ asset($course->image) }}" />
						</div>
					</div>
					<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
						<div class="card-author d-flex d-none">
						</div>
						<div class="pt-6">
							<h3 class="h4 mb-4">
								<a href="{{ route('course-detail', $course->slug) }}">{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
	<div class="container py-4 d-none">
		<div class="row mt-n1-9">
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-01.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ count($colleges) }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.total_institution')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-03.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ count($colleges) * 200 }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.total_seats')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-02.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ $students ?? '0' }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.student_enrollment')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-04.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">30</span>+
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.certified_teachers')</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container pt-lg-4">

		<div class="shape19">
			<img src="{{ asset('front/img/bg/shape22.png') }}" alt="..." />
		</div>
		<div class="shape22">
			<img src="{{ asset('front/img/bg/shape23.png') }}" alt="..." />
		</div>
	</div>
</section>


<!-- ONLINE TEACHERS
	================================================== -->
<section class="position-relative py-5">
	<div class="container">
		<div class="section-heading">
			<h2 class="membrr-all">@lang('messages.our_teachers')</h2>
		</div>
		<div class="swiper-ap">
			<div class="swiper-wrapper">
				<!-- Slide 1 -->
				@if(filled($teachers))
					@foreach($teachers as $teacher)
					<a href="{{route('teacher-info',encrypt($teacher->id))}}">
						<div class="swiper-slide">
							<div class="team-style1 text-center">
								<img src="{{  asset($teacher->image) }}" class="border-radius-5" alt="{{  asset($teacher->image) }}" />
								<div class="team-info">
									<h3 class="text-primary mb-1 h4">{{  $teacher->name  }}</h3>
									<span class="font-weight-600 text-secondary">Experience :  {{  $teacher->experience }} Year</span>
								</div>
								<div class="team-overlay">
									<div class="d-table h-100 w-100">
										<div class="d-table-cell align-middle">
											<h3><a href="{{route('teacher-info',encrypt($teacher->id))}}" class="text-white">{{  $teacher->name  }}</a></h3>
											<p class="text-white mb-0">{{  $teacher->education  }} {!!$teacher->about!!}</p>
											<div class="social-linkks d-none">
												<a href="youtube.com/@JyotirmathShankaracharya">
													<i class="fa-brands fa-youtube"></i>
												</a>
												<a href="twitter.com/jyotirmathah?t=haDwj15roOCHEGjZmFQWQQ&s=09">
													<i class="fa-brands fa-twitter"></i>
												</a>
												<a href="https://www.instagram.com/1008.guru?igsh=MWV0MnRoaWlwZXp4ZQ==">
													<i class="fa-brands fa-instagram"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>						
					@endforeach
				@endif

				
			</div>
		</div>

		<div class="shape18">
			<img src="{{asset('front/images/bg-01.jpg')}}" alt="..." />
		</div>
		<div class="shape20">
			<img src="{{asset('front/images/bg-02.jpg')}}" alt="..." />
		</div>
		<div class="shape21">
			<img src="{{asset('front/images/bg-03.jpg')}}" alt="..." />
		</div>
	</div>
</section>


<!-- ONLINE INSTRUCTORS
	================================================== -->
<section class="position-relative py-5">
	<div class="container">
		<div class="section-heading">
			<h2 class="membrr-all">@lang('messages.our_guardians')</h2>
		</div>
		<div class="swiper-ap">
			<div class="swiper-wrapper">
				<!-- Slide 1 -->
				<div class="swiper-slide">
					<div class="team-style1 text-center">
						<img src="{{asset('front/images/guru6.png')}}" class="border-radius-5" alt="..." />
						<div class="team-info">
							<h3 class="text-primary mb-1 h4">Jagadguru Shankaracharya Avimuketshwarananda Ji</h3>
							<span class="font-weight-600 text-secondary">Jagadguru Shankaracharya Avimuketshwarananda Ji</span>
						</div>
						<div class="team-overlay">
							<div class="d-table h-100 w-100">
								<div class="d-table-cell align-middle">
									<h3><a href="#" class="text-white">Jagadguru Shankaracharya Avimuketshwarananda Ji</a></h3>
									<p class="text-white mb-0">Jagadguru Shankaracharya Avimuketshwarananda Ji</p>
									<div class="social-linkks d-flex">
										<a href="youtube.com/@JyotirmathShankaracharya">
											<i class="fa-brands fa-youtube"></i>
										</a>
										<a href="twitter.com/jyotirmathah?t=haDwj15roOCHEGjZmFQWQQ&s=09">
											<!-- <i class="fa-brands fa-facebook-f"></i> -->
											<i class="fa-brands fa-twitter"></i>
										</a>
										<a href="https://www.instagram.com/1008.guru?igsh=MWV0MnRoaWlwZXp4ZQ==">
											<i class="fa-brands fa-instagram"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Slide 2 -->
				<div class="swiper-slide">
					<div class="team-style1 text-center">
						<img src="{{asset('front/images/wangchuk1.png')}}" class="border-radius-5" alt="..." />
						<div class="team-info">
							<h3 class="text-primary mb-1 h4">Sonam Wangchuk</h3>
							<span class="font-weight-600 text-secondary">Indian Engineer & Innovator</span>
						</div>
						<div class="team-overlay">
							<div class="d-table h-100 w-100">
								<div class="d-table-cell align-middle">
									<h3><a href="#" class="text-white">Indian Engineer & Innovator</a></h3>
									<p class="text-white mb-0">Sonam Wangchuk</p>
									<div class="social-linkks d-flex">
										<a href="youtube.com/@sonamwangchuk66?si=u1IO3gbLXGEHPibz">
											<i class="fa-brands fa-youtube"></i>
										</a>
										<a href="https://www.facebook.com/share/1AhMFF47V4/?mibextid=wwXIfr">
											<i class="fa-brands fa-facebook-f"></i>
										</a>
										<a href="https://www.instagram.com/wangchuksworld?igsh=cnFkeTRqazZ2aDJ3">
											<i class="fa-brands fa-instagram"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Slide 3 -->
				<div class="swiper-slide">
					<div class="team-style1 text-center">
						<img src="{{asset('front/images/sant.png')}}" class="border-radius-5" alt="..." />
						<div class="team-info">
							<h3 class="text-primary mb-1 h4">"Sant Gopol Das"</h3>
							<span class="font-weight-600 text-secondary">"Head of Ayodhya Tample"</span>
						</div>
						<div class="team-overlay">
							<div class="d-table h-100 w-100">
								<div class="d-table-cell align-middle">
									<h3><a href="#" class="text-white">"Sant Gopol Das"</a></h3>
									<p class="text-white mb-0">"Head of Ayodhya Tample"</p>
									<div class="social-linkks d-flex">
										<a href="">
											<i class="fa-brands fa-youtube"></i>
										</a>
										<a href="">
											<i class="fa-brands fa-facebook-f"></i>
										</a>
										<a href="">
											<i class="fa-brands fa-instagram"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Slide 4 -->
				<div class="swiper-slide">
					<div class="team-style1 text-center">
						<img src="{{asset('front/images/Muni ji2.jpg')}}" class="border-radius-5" alt="..." />
						<div class="team-info">
							<h3 class="text-primary mb-1 h4">"श्री श्रेयांस मुनि जी महाराज"</h3>
							<span class="font-weight-600 text-secondary">"श्री श्रेयांस मुनि जी महाराज"</span>
						</div>
						<div class="team-overlay">
							<div class="d-table h-100 w-100">
								<div class="d-table-cell align-middle">
									<h3><a href="#" class="text-white">"श्री श्रेयांस मुनि जी महाराज"</a></h3>
									<p class="text-white mb-0">"श्री श्रेयांस मुनि जी महाराज"</p>
								</div>
								<div class="social-linkks">
									<a href="">
										<i class="fa-brands fa-youtube"></i>
									</a>
									<a href="">
										<i class="fa-brands fa-facebook-f"></i>
									</a>
									<a href="">
										<i class="fa-brands fa-instagram"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="shape18">
			<img src="{{asset('front/images/bg-01.jpg')}}" alt="..." />
		</div>
		<div class="shape20">
			<img src="{{asset('front/images/bg-02.jpg')}}" alt="..." />
		</div>
		<div class="shape21">
			<img src="{{asset('front/images/bg-03.jpg')}}" alt="..." />
		</div>
	</div>
</section>


<!-- OUR TRUST
	================================================== -->

<section class="aboutus-style-01 position-relative bg-very-light-gray py-3">
	<div class="container">
		<div class="section-heading">
			<h2 class="h1 mb-0">Associated Trusts</h2>
		</div>
		<div class="row g-xxl-5 mt-n2-6 justify-content-center">
			@if(isset($courses))
			@foreach($courses as $course)
			<div class="col-md-6 col-xl-4 mt-3">
				<div class="card card-style1 p-0 h-100">
					<div class="card-img rounded-0">
						<div class="image-hover">
							<img class="rounded-top" src="https://images.unsplash.com/photo-1577366325138-648f707a75e5?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2hhcml0YWJsZSUyMHRydXN0fGVufDB8fDB8fHww" alt="{{ asset($course->image) }}" />
						</div>
					</div>
					<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
						<div class="card-author d-flex d-none">
						</div>
						<div class="pt-6">
							<h3 class="h4 mb-4">
								<a href="{{ route('course-detail', $course->slug) }}">Gaam Raam Prasath Charitable Trust</a>
							</h3>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
	<div class="container py-4 d-none">
		<div class="row mt-n1-9">
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-01.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ count($colleges) }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.total_institution')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-03.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ count($colleges) * 200 }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.total_seats')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-02.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">{{ $students ?? '0' }}</span>
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.student_enrollment')</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mt-1-9 counter-col-div">
				<div class="counter-wrapper">
					<div class="counter-icon">
						<div class="d-table-cell align-middle">
							<img src="{{asset('front/images/icon-04.png')}}" class="w-55px" alt="..." />
						</div>
					</div>
					<div class="counter-content">
						<h4 class="counter-number">
							<span class="countup">30</span>+
						</h4>
						<p class="mb-0 font-weight-600">@lang('messages.certified_teachers')</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container pt-lg-4">

		<div class="shape19">
			<img src="{{ asset('front/img/bg/shape22.png') }}" alt="..." />
		</div>
		<div class="shape22">
			<img src="{{ asset('front/img/bg/shape23.png') }}" alt="..." />
		</div>
	</div>
</section>


<!-- member sectionn -->
<section class="py-5 member-section-div py-5">
	<div class="container">
		<div class="row">
			<div class="section-heading member-contentt">
				<!-- <span class="sub-title">process</span> -->
				<h2 class="membrr-all my-4  my-sm-2 text-center">@lang('messages.become_a_part_of_the_gaamraam_family')</h2>
				<p class="py-3 text-center ">@lang('messages.gaamraam_is_more_than_just_an_organization_it_is_a_movement_a_family_united_by_action_and_a_shared_dream_of_a_better_future_here_every_effort_counts_every_voice_matters_no_matter_where_you_are_you_belong')</p>
			</div>
		</div>
		<div class="row">

			<div class="col-lg-6 my-1">
				<div class="process-content-teacher member-card-div-2">
					<h3>@lang('messages.indian_member')</h3>
					<h5 class="">@lang('messages.be_the_change_in_your_community')</h5>
					<p class="mb-0">@lang('messages.opportunities_arent_equal_for_everyone_but_together_we_can_change_that') </p>
					<ul>
						<li><strong>@lang('messages.membership_fee')</strong> @lang('messages.100_a_small_contribution_a_big_impact') </li>
						<li><strong>@lang('messages.on_ground_action')</strong> @lang('messages.be_the_force_of_change_participate_in_social_initiatives_awareness_drives_and_community_programs')</li>
						<li> <strong>@lang('messages.volunteer_leadership')</strong> @lang('messages.lead_teams_organize_events_and_make_a_real_impact_where_its_needed_most') </li>
						<li> <strong>@lang('messages.social_media_engagement')</strong> @lang('messages.use_your_voice_to_amplify_causes_mobilize_support_and_inspire_action') </li>
					</ul>
					<div class="member-read-more my-4">
						<a href="{{url('member-register?form=indian-member') }}"> @lang('messages.join_now')</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6 my-1">
				<div class="process-content-teacher member-card-div-2">
					<h3>@lang('messages.nri_member')</h3>
					<h5 class="">@lang('messages.stay_connected_to_your_roots_create_impact') </h5>

					<p class="text-center">
						@lang('messages.you_know_what_it_means_to_be_far_from_home_the_struggles_the_sacrifices_now_you_have_the_power_to_ensure_no_child_in_your_village_has_to_leave_just_to_survive')
					</p>
					<ul>
						<li><strong>@lang('messages.membership_fee')</strong>@lang('messages.just_one_hours_earnings_per_month_turn_your_success_into_someones_chance')</li>
						<li><strong>@lang('messages.digital_advocacy')</strong> @lang('messages.use_your_reach_to_spread_awareness_inspire_action_and_bring_people_together')</li>
						<li><strong>@lang('messages.global_outreach')</strong>@lang('messages.connect_with_changemakers_worldwide_and_expand_the_mission_beyond_borders')</li>
						<li> <strong>@lang('messages.strategic_support')</strong> @lang('messages.mentor_fund_or_network_because_real_change_knows_no_boundaries')
						</li>
					</ul>
					<div class="member-read-more my-4">
						<a href="{{url('member-register?form=nri-member')}}">@lang('messages.join_now')</a>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="section-heading member-contentt py-4 ">
				<!-- <span class="sub-title">process</span> -->
				<h3 class="membrr-all">@lang('messages.a_family_built_on_trust_and_transparency')
				</h3>
				<p class="">@lang('messages.at_gaamraam_every_rupee_counts_and_every_effort_matters_donations_are_recorded_expenses_updated_in_real_time_with_verified_bills_and_all_financial_records_open_to_the_public_ensuring_complete_transparency_here_leadership_isnt_given_its_earned_through_dedication_and_impact_not_connections_our_social_credit_points_system_esnures_that_every_contribution_is_recognized_fairly_giving_members_respect_influence_and_a_voice_in_decision_making_based_on_their_real_impact.')</p>
			</div>
		</div>
		<div class="row">
			<div class="counter-container">
				<div class="row">
					<div class="counter-container">
						<div class="row">

							<div class="col-md-4 my-1">
								<a href="{{route('donation-detail')}}">
									<div class="counter-box">
										<i class="fas fa-money-bill fa-3x"></i>
										<p class="pb-0">@lang('messages.total_received_amount')</p>
										<div class="member-counter" id="received">0</div>
									</div>
								</a>
							</div>

							<div class="col-md-4 my-1 ">
								<a href="{{route('donation-detail')}}">
									<div class="counter-box">
										<i class="fas fa-wallet fa-3x"></i> <!-- Expense Icon -->
										<p class="pb-0">@lang('messages.total_expend_amount')</p>
										<div class="member-counter" id="spent">0</div>
									</div>
								</a>
							</div>
							<div class="col-md-4 my-1">
								<a href="{{route('donation-detail')}}">
									<div class="counter-box">
										<i class="fas fa-piggy-bank fa-3x"></i> <!-- Remaining Money Icon -->
										<p class="pb-0">@lang('messages.total_remaining_amount')</p>
										<div class="member-counter" id="remaining">0</div>
									</div>
								</a>
							</div>

						</div>
					</div>
				</div>



			</div>
		</div>
	</div>
</section>

<!-- Member section -->
<section class="py-1 bg-very-light-gray py-4">
  <div class="container">
    <div class="section-heading py-4 mb-0">
      <h2 class="membrr-all">Our Members</h2>
    </div>
    <div class="swiper member-swiper">
      <div class="swiper-wrapper">
        @isset($members)
        @foreach($members as $member)
        <div class="swiper-slide">
          <div class="member-cardss" style="height:100%;">
            <div class="student-image-block mb-1">
              @if($member->profile_image != null)
              <img src="{{ asset($member->profile_image) }}" alt="Member Image" />
              @else
              <img src="{{ asset('front/images/boy.png') }}" alt="Default Image" />
              @endif
            </div>
            <h3 class="pt-1">{{ $member->name ?? 'N/A' }}</h3>
            <p class="mb-0">Social Point :- {{ $member->points ?? '0' }}</p>
            <p class="mb-0">Member Id :- {{ $member->id }}</p>
          </div>
        </div>
        @endforeach
        @endisset
      </div>

      <!-- Optional controls -->
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>




<!-- Member section -->
<section class="py-1 bg-very-light-gray py-4">
	<div class="container">
		<div class="section-heading py-4 mb-0">
			<h2 class="membrr-all">District Member</h2>
		</div>
		<div class="row">
			<div class="search_member w-md-50 m-auto">
				<h5 class="text-center">Select a City to Connect with Members</h5>
				<form action="" method="GET" id="cityForm">
					<select name="city"  class="form-select">
						<option value="" selected disabled>Select City</option>
						@isset($citys)
							@foreach($citys as $city)
								<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endforeach 
						@endisset						
					</select>
				</form>

			</div>
			<div class="process-wrapper memb-card-slide mt-5">
				<div class=" district-member-wrapper">
					<div class="swiper-wrapper" id="district-member-wrapper">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>




<!-- PARTNER
	================================================== -->
<!-- <section class="py-3">
	<div class="container">
		<div class="client-carousel owl-carousel owl-theme">
			@if(isset($colleges))
			@foreach($colleges as $college)
			<a href="{{ $college->website_link }}" target="_blank">
				<div class="review-colloge">
					<img src="{{ asset($college->logo) }}" alt="{{ asset($college->logo) }}">
					<h6 class="text-center text-white">{{ $college->name ?? '' }}</h6>
				</div>
			</a>
			@endforeach
			@endif
		</div>
	</div>
</section> -->


@endsection
@push('js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
	var validateEmailRoute = "{{ route('student-validate-email') }}";
	var getMemberByCityRoute = "{{ url('fetch-member-by-city') }}/";
	var sendOtpRoute = "{{ route('send.otp') }}";
	var verifyOtp = "{{ route('verify.otp') }}";
	var sendOtpWhatsappRoute = "{{ route('send.whatsapp.otp') }}";
	var verifyWhatsappOtp = "{{ route('verify.whatsapp.otp') }}";
	let rawAmount = "{{ $total_amount }}";
	let receivedAmount = parseInt(rawAmount.replace(/[^0-9]/g, '')) || 0;
	const langMessages = {
		signUp: "{{ __('messages.sign_up') }}"
	};
	let spentAmount = 100259;

	let actualreceivedAmount = 101317 + receivedAmount;
	let remainingBalance = actualreceivedAmount - spentAmount;

	console.log("Raw amount:", rawAmount);
	console.log("Parsed amount:", receivedAmount);
	console.log("Actual Received:", actualreceivedAmount);
	console.log(sendOtpRoute);
	console.log(verifyOtp);
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".member-swiper", {
      spaceBetween: 20,
      loop: true,
      slidesPerView: 1,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
        1280: {
          slidesPerView: 4,
        },
      },
    });
  });
</script>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const swiper = new Swiper(".district-member-wrapper", {
      spaceBetween: 20,
      slidesPerView: 1,
      loop: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
        1280: {
          slidesPerView: 4,
        },
      },
    });
  });
</script>

<script>
document.getElementById('verifyMethod').addEventListener('change', function() {
    const emailOption = document.getElementById('emailOption');
    const whatsappOption = document.getElementById('whatsappOption');
    
    if (this.value === 'email') {
        emailOption.style.display = 'block';
        whatsappOption.style.display = 'none';
    } else {
        emailOption.style.display = 'none';
        whatsappOption.style.display = 'block';
    }
});
</script>



@endpush