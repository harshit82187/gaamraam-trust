@extends('front.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@php $formType = request()->get('form'); @endphp
<div class="container mt-5" data-show-login="{{ session('showLogin') ? 'true' : 'false' }}">
	<div class="row">
		<div class="col-12 col-lg-5">
			<!-- <div class="register-image-block" style="height: 93%;"> -->
			<div class="register-image">
				<!-- <img src="{{ asset('app/courses/2025/Feb/1740647495.jpg') }}" alt="{{ asset('app/courses/2025/Feb/1740647495.jpg') }}"> -->
				<img src="../public/front/images/register/membership.jpg" alt="">
			</div>
		</div>
		<div class="col-12 col-lg-7">
			<div id="paymentLoader" class="loader-overlay" style="display: none;">
				<div class="loader"></div>
				<p>⏳ Processing Payment, Please Wait...</p>
			</div>
			<div class="registeration-form-member ">
				<div id="registration-form" class="form-container active registration-form" style="{{ ($formType == 'login' || $formType == 'forgot') ? 'display:none;' : '' }}">
					<h2>@lang('messages.register')</h2>
					<form id="register-form" action="{{ route('member-register') }}" method="post" enctype="multipart/form-data" class="pt-5">
						<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
						<input type="hidden" name="transaction_via" value="razorpay">
						<input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
						<input type="hidden" name="currency" id="razorpay_currency">
						@csrf
						<div>
							<label for="">@lang('messages.name')</label><span class="text-danger">*</span>
							<input type="text" class="alphabet" name="name" id="regName" value="{{ old('name') }}" autocomplete="one-time-code" placeholder="@lang('messages.enter_your_name')" required>
							@error('name')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div>
							<label>@lang('messages.email')</label><span class="text-danger">*</span>
							<input type="email" name="email" id="regEmail" value="{{ old('email') }}" placeholder="@lang('messages.enter_your_mail')" oncopy="return false" oncut="return false" onpaste="return false" autocomplete="one-time-code" required>
							<span id="regEmailError" class="text-danger"></span>
							@error('email')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div>
							<label>@lang('messages.mobile_number')</label><span class="text-danger">*</span>
							<input type="text" name="mobile" id="regMobile" value="{{ old('mobile') }}" oncopy="return false" oncut="return false" onpaste="return false" placeholder="@lang('messages.enter_your_mobile_number')" autocomplete="one-time-code" required>
							<span id="regMobileError" class="text-danger"></span>
							@error('mobile')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="d-flex align-items-center gap-1 select-typee">
							<!-- <label>Member Type</label><span class="text-danger"></span> -->
							<div class="label-div d-flex gap-2 radio-group">
								<div class="">
									<input type="radio" name="member_type" id="indian" checked value="1" required class="custom-radio">
									<label for="indian" class="radio-label">@lang('messages.indian')</label>
								</div>
								<div class="">
                                    <input type="radio" name="member_type" id="nri" value="2" required class="custom-radio">
                                    <label for="nri" class="radio-label">@lang('messages.nri')</label>
                                </div>
							</div>
						</div>
						<div id="passport-field" style="display:none;">
							<label>@lang('messages.passport_number')</label><span class="text-danger">*</span>
							<input type="text" name="passport" id="passport" placeholder="@lang('messages.enter_your_passport_number')" autocomplete="one-time-code">
							@error('passport')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div id="country-field" style="display:none;">
							<label>@lang('messages.your_current_working_country') <span class="text-danger">*</span></label>
							@php $countries = DB::table('countries')->get(); @endphp
							<select name="country" id="" class="form-control select22">
								<option value="">-- @lang('messages.select_country')--</option>
								@foreach($countries as $country)
									<option value="{{ $country->name }}">{{ $country->name }}</option>
								@endforeach
							</select>
							@error('country')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div>
							<label>@lang('messages.password')</label><span class="text-danger">*</span>
							<div class="password-container">
								<input type="password" name="password" id="regPassword" placeholder="@lang('messages.create_your_password')" autocomplete="one-time-code" required>
								<span class="eye-icon" id="togglePassword">
									<i class="fas fa-eye"></i>
								</span>
							</div>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<!-- <div>
							<label>Password</label><span class="text-danger">*</span>
							<input type="password" name="password" id="regPassword" placeholder="Enter Your Password" autocomplete="one-time-code" required>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
							</div> -->
						<div>
							<label>@lang('messages.confirm_password')</label><span class="text-danger">*</span>
							<div class="password-container">
								<input type="password" name="cpassword" id="regCPassword" placeholder="@lang('messages.confrim_your_password')" autocomplete="one-time-code" required>
								<span class="eye-icon" id="toggleCPassword">
									<i class="fas fa-eye"></i>
								</span>
							</div>
							<span id="regCPassword-error" class="text-danger" ></span>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="payment-mode-custom-select">
							<label>@lang('messages.blood_group')</label><span class="text-danger">*</span>
							<select name="blood_group" id="blood_group" class="form-control select" required>
								<option value="A+" >A+</option>
								<option value="A−">A−</option>
								<option value="B+" >B+</option>
								<option value="B-">B-</option>
								<option value="AB+" >AB+</option>
								<option value="AB−">AB−</option>
								<option value="O+" >O+</option>
								<option value="O-">O</option>
							</select>
							<i class="fas fa-chevron-down"></i>
						</div>
						<!-- <div>
							<label>Confirm Password</label><span class="text-danger">*</span>
							<input type="password" name="cpassword"  placeholder="Enter Your Confirm Password" autocomplete="one-time-code" required>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
							</div> -->
						<div>
							<label id="amount-label"></label><span class="text-danger">*</span>
							<input type="number" name="amount" id="amount" autocomplete="one-time-code" required>
							@error('password')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="mt-2 d-none">
							<label>@lang('message.select_membership_type')</label><br>
							<div class="select-membership d-flex">
								<input type="radio" name="membership_type" value="monthly" checked required>
								<label id="monthly-membership-label">@lang('messages.monthly_membership_100_per_month')</label><br>
							</div>
							<div class="select-membership d-flex">
								<input type="radio" name="membership_type" value="yearly">
								<label id="yearly-membership-label">@lang('messages.yearly_membership_1100_per_year')</label>
							</div>
						</div>
						<p>@lang('messages.your_bank_account_will_be_automatically_detected_whenever_your_membership_renewal_date_is_near')</p>
						<div class="payment-mode-custom-select">
							<label>@lang('messages.payment_mode')</label><span class="text-danger">*</span>
							<select name="mode" id="mode" class="form-control select" required>
								<option value="1" selected>Razorpay</option>
								<option value="3">Offline Mode (Bar Code Scan) </option>
							</select>
							<i class="fas fa-chevron-down"></i>
						</div>
						<div class="g-recaptcha mt-3" data-sitekey="6LcdiiIrAAAAAM95DdpLGBA57sVf2XZ-B1Ot4_Kw"></div> 
						<span id="captchaError" style="font-size: 20px;" class="text-danger"></span>
						<span id="qr-code-body" class="mt-2"></span>
						<button type="submit" class="mt-3" id="regSubmit">@lang('messages.register')</button>
					</form>
					<div class="link-member">
						<p>@lang('messages.already_have_an_account') <a href="{{ url('member-register?form=login') }}" >@lang('messages.login')</a></p>
					</div>
				</div>
				<div id="login-form" class="form-container login-form"  style="{{ ($formType == 'login') ? 'display:block;' : 'display:none;' }}">
					<h2>@lang('messages.login')</h2>
					<div id="login-form-error" style="display:none; color: red; margin-bottom: 10px;"></div>
					<form id="member-login-form">
						@csrf
						<label>@lang('messages.email')</label><span class="text-danger">*</span>
						<input type="email" name="email" placeholder="@lang('messages.enter_your_mail')" required>
						<div class="login-password-container">
							<label>@lang('messages.password')</label><span class="text-danger">*</span>
							<div class="password-container">
								<input type="password" name="password" id="loginPassword" placeholder="@lang('messages.enter_your_password')" required>
								<span class="eye-icon" id="toggleLoginPassword">
									<i class="fas fa-eye"></i>
								</span>
							</div>
						</div>
						<!-- <input type="password" name="password" placeholder="Enter Your Password" required> -->
						<button type="submit" id="member-login-button">@lang('messages.login')</button>
					</form>
					<div class="link-member">
						<p>@lang('messages.forgot_your_password') <a href="{{ url('member-register?form=forgot') }}" >@lang('messages.forgot_your_password')</a></p>
						<p>@lang('messages.dont_have_an_account')<a href="{{ url('member-register') }}" onclick="showRegistrationForm()">@lang('messages.register')</a></p>
					</div>
				</div>
				<div id="forgot-password-form" class="form-container"  style="{{ ($formType == 'forgot') ? 'display:block;' : 'display:none;' }}">
					<h2>@lang('messages.forgot_your_password')</h2>
					<form id="forget-password-form" action="{{ route('forget-password') }}" method="POST">
						@csrf
						<input type="email" id="forgotEmail" name="email" autocomplete="one-time-code" placeholder="@lang('messages.enter_your_mail')" required>
						<div id="recaptcha-forget" class="g-recaptcha mt-3 " data-sitekey="6LcdiiIrAAAAAM95DdpLGBA57sVf2XZ-B1Ot4_Kw"></div> 
						<span id="captchaError2" style="font-size: 20px;" class="text-danger"></span>
						<button class="mt-2" type="submit">@lang('messages.reset_password')</button>
					</form>
					<div class="link-member">
						<p><a href="{{ url('member-register?form=login') }}" >@lang('messages.login')</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<h2 class="h1 py-2 text-center">@lang('messages.member_details')</h2>
	</div>
	<div class="row py-5">
		<div class="row">
			<div class="process-wrapper memb-card-slide">
				<div class="member-swiper-container">
					<div class="swiper-wrapper">
						@php $members = \App\Models\User::where('status','1')->orderBy('points', 'desc')->get(); @endphp
						@isset($members)
						@foreach($members as $member)
						<div class="swiper-slide">
							<div class="member-cardss" style="height:100%;">
								<div class="student-image-block mb-1">
									@if($member->profile_image != null)
									<img src="{{ asset($member->profile_image) }}" alt="{{ asset($member->profile_image) }}" />
									@else
									<img src="{{ asset('front/images/boy.png') }}" alt="{{ asset('front/images/boy.png') }}" />
									@endif
								</div>
								<h3 class="pt-1">{{ $member->name ?? 'N/A' }}</h3>
								<p class="mb-0">Soical Point :- {{ $member->points ?? '0' }}</p>
								<p class="mb-0">Member Id :- {{ $member->id }}</p>
							</div>
						</div>
						@endforeach
						@endisset
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('front/js/member-login.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script>
	var memberLoginRoute = "{{ route('member-login') }}";
	var validateEmailRoute = "{{ route('validate-email') }}";
	var validateMobileNoRoute = "{{ route('validate-mobile') }}";
	var baseUrl = "{{ asset('front/images/GammRaamQrCode.PNG') }}";
	var razorpay_logo = "{{ asset('front/images/Gaam_Raam_logo.png') }}";
	var RAZORPAY_KEY = "{{ env('RAZORPAY_KEY') }}";
	var MONTHLY_PLAN_ID = "{{ env('RAZORPAY_MONTHLY_PLAN_ID') }}";
	var ANNUAL_PLAN_ID = "{{ env('RAZORPAY_ANNUAL_PLAN_ID') }}";
	window.translations = {
        amount_minimum_payable_100: "@lang('messages.amount_minimum_payable_100')",
        amount_minimum_payable_10_usd: "@lang('messages.amount_minimum_payable_10_usd')",
    };
</script>
<script>
    let recaptchaWidgets = {};
    function onloadCallback() {
        recaptchaWidgets.forget = grecaptcha.render('recaptcha-forget', {
            'sitekey': '6LcdiiIrAAAAAM95DdpLGBA57sVf2XZ-B1Ot4_Kw'
        });
        
        // Example for other forms:
        // recaptchaWidgets.register = grecaptcha.render('recaptcha-register', {
        //     'sitekey': 'your-site-key'
        // });
    }
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const urlParams = new URLSearchParams(window.location.search);
		const formType = urlParams.get('form');
		if (formType === 'indian-member') {
			document.getElementById('indian').checked = true;
			document.getElementById('passport-field').style.display = 'none';
			document.getElementById('country-field').style.display = 'none';
			document.getElementById('passport').removeAttribute('required');
			document.getElementById('country').removeAttribute('required');
			document.getElementById('passport').value = '';
			document.getElementById('amount').value = 100;
			document.getElementById('amount-label').innerHTML = "Amount (Minimum payable amount is 100 Rupees)";
			document.getElementById('monthly-membership-label').innerHTML = "Monthly Membership (100 Rupees per month)";
			document.getElementById('yearly-membership-label').innerHTML = "Yearly Membership (1100 Rupees per year)";
			document.getElementById('razorpay_currency').value = "INR";
		} else if (formType === 'nri-member') {
			document.getElementById('nri').checked = true;
			document.getElementById('passport-field').style.display = 'block';
			document.getElementById('country-field').style.display = 'block';
			document.getElementById('passport').setAttribute('required', true);
			document.getElementById('country').setAttribute('required', true);
			document.getElementById('amount').value = 10;
			document.getElementById('amount-label').innerHTML = "Amount (Minimum payable amount is 10 USD)";
			document.getElementById('monthly-membership-label').innerHTML = "Monthly Membership (10 USD per month)";
			document.getElementById('yearly-membership-label').innerHTML = "Yearly Membership (110 USD per year)";
			document.getElementById('razorpay_currency').value = "USD";
		}
	});
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Select Country --",
            allowClear: true
        });
    });
</script>
@endpush