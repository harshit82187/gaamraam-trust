@extends('front.layout.app')
@section('content')
<div id="paymentLoader" class="loader-overlay d-none"  >
    <div class="loader"></div>
    <p class="processing" >⏳ Processing Payment, Please Wait...</p>
</div>
<section class="banner-section">
	<div class="overlay-div"></div>
	<div class="container">
		<div class="donate-banner">
			<h2 class="text-white">@lang('messages.start_donation_today')</h2>
			<p class="text-white">@lang('messages.make_difference_contribution')</p>
		</div>
	</div>
</section>
<div class="container my-5">
	<div class="row">
		<div class="col-lg-6">			
			<div class="donation-contentt">
				<div class="donate-image">
					<img src="{{ asset('front/images/Donate.jpeg') }}" alt="{{ asset('front/images/Donate.jpeg') }}">
				</div>				
				<div class="content-div-box">
					<h5 class="text-center my-2">@lang('messages.thank_you_willingness_to_give')</h5>
					<p class="text-center">@lang('messages.your_kindness_and_generosity_mean_a_lot_we_truly_appreciate_your_support_in_making_a_difference')</p>
					<p class="text-center">@lang('messages.but_before_you_proceed_we_invite_you_to_take_a_bigger_step_become_a_member_why_because_as_a_member_you_dont_just_donate_you_see_the_impact_you_create_and_become_part_of_real_lasting_change')</p>
					<h6 class="text-center">@lang('messages.why_become_a_member')</h6>
					<ul class="">
						<li>@lang('messages.see_your_contribution_in_action_track_how_your_support_transforms_lives')</li>
						<li>@lang('messages.be_a_changemaker_not_just_a_donor_play_an_active_role_in_shaping_the_future')</li>
						<li>@lang('messages.multiply_your_impact_support_meaningful_causes_beyond_a_one_time_donation')</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="donate-form">
				<div class="donation-heading text-center">
					<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="{{ asset('front/images/Gaam_Raam_logo.png') }}">
					<h2>@lang('messages.ngo_donation_form')</h2>
				</div>
				<form id="donate-online" action="{{ route('donate-now-amount') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
					<input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
					<input type="hidden" name="transaction_via" value="razorpay">
					<input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
					<div class="form-group">
						<label for="name">@lang('messages.name')</label>
						<input type="text" name="name" class="form-control alphabet" id="name" aria-describedby="">
					</div>
					<div class="form-group">
						<label for="number">@lang('messages.phone') <span class="text-danger" >*</span></label>
						<input type="text" name="mobile_no" class="form-control number" id="mobile_no" required>
					</div>
					<div class="form-group">
						<label for="number">@lang('messages.email')</label>
						<input type="email" name="email" class="form-control" id="donor_email">
					</div>
					<div class="form-group">
						<label for="amount">@lang('messages.Amount')<span class="text-danger" >*</span></label>
						<input type="text" name="amount" class="form-control number" id="amount" required>
					</div>
					<div class="form-group">
						<label for="mode">@lang('messages.Payment Mode')<span class="text-danger" >*</span></label>
						<select class="form-control select" required name="mode" id="mode">
							<option class="form-control" value="1">Razorpay</option>
							<option class="form-control" value="2">Offline Mode (Bar Code Scan)</option>
						</select>
					</div>
					<div id="qr-code-body" style="display:none;"></div>
					<button type="submit" id="donate-now-submit" class="btnn-donate mt-3">@lang('messages.donate_now')</button>
				</form>
				<p class="text-center become-textt">@lang('messages.if_you_want_to_become_a_part_of_gaamraam_then_join_us')</p>
				<a href="{{ url('member-register') }}" class="text-center donate-arrow"><i class="fa-solid fa-hand-pointer blinking-text"></i>@lang('messages.become_a_member')</a>
			</div>
		</div>
	</div>
</div>
<section class="donation-section py-1">
	<div class="container">
		<div class="denoation-amount-div">			
			<div class="row">
				<div class="section-heading member-contentt py-4 ">
					<h3 class="membrr-all">@lang('messages.a_family_built_on_trust_and_transparency')
					</h3>
					<p class="">@lang('messages.at_gaamraam_every_rupee_counts_and_every_effort_matters_donations_are_recorded_expenses_updated_in_real_time_with_verified_bills_and_all_financial_records_open_to_the_public_ensuring_complete_transparency_here_leadership_isnt_given_its_earned_through_dedication_and_impact_not_connections_our_social_credit_points_system_esnures_that_every_contribution_is_recognized_fairly_giving_members_respect_influence_and_a_voice_in_decision_making_based_on_their_real_impact.')</p>
				</div>
			</div>
			<div class="row">
				<div class="counter-container">
					<div class="row">
						<div class="col-md-4 my-1">
							<div class="counter-box">
								<i class="fas fa-money-bill fa-3x"></i>
								<p class="pb-0">@lang('messages.total_received_amount')</p>
								<div class="member-counter" id="received">0</div>
							</div>
						</div>
						<div class="col-md-4 my-1 ">
							<div class="counter-box">
								<i class="fas fa-wallet fa-3x"></i> <!-- Expense Icon -->
								<p class="pb-0">@lang('messages.total_expend_amount')</p>
								<div class="member-counter" id="spent">0</div>
							</div>
						</div>
						<div class="col-md-4 my-1">
							<div class="counter-box">
								<i class="fas fa-piggy-bank fa-3x"></i> <!-- Remaining Money Icon -->
								<p class="pb-0">@lang('messages.total_remaining_amount')</p>
								<div class="member-counter" id="remaining">0</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@push('js')
<script>
	var RAZORPAY_KEY = "{{ getenv('RAZORPAY_KEY') }}";
	var razorpay_logo = "{{ asset('front/images/Gaam_Raam_logo.png') }}";
	let rawAmount = "{{ $total_amount }}";
	let receivedAmount = parseInt(rawAmount.replace(/[^0-9]/g, '')) || 0;
	let spentAmount = 100259;
	let actualreceivedAmount = 101317 + receivedAmount;
	let remainingBalance = actualreceivedAmount - spentAmount;
	const razorpayInitiateUrl = "{{ route('razorpay-intitial-payment') }}";
	console.log("Raw amount:", rawAmount);
	console.log("Parsed amount:", receivedAmount);
	console.log("Actual Received:", actualreceivedAmount);
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('front/js/razorpay.js') }}"></script>
<script>
	$(document).ready(function() {
		// Swiper: Slider
		new Swiper('.swiper-container-donation', {
			loop: true,
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			slidesPerView: 3,
			paginationClickable: true,
			spaceBetween: 20,
			breakpoints: {
				320: {
					slidesPerView: 1, // 1 slide for very small screens (mobile devices)
					spaceBetween: 10, // Space between slides
				},
				480: {
					slidesPerView: 1, // 1 slide for mobile devices in portrait mode
					spaceBetween: 10, // Space between slides
				},
				768: {
					slidesPerView: 2, // 2 slides for tablets and small screens
					spaceBetween: 20, // Space between slides
				},
				1024: {
					slidesPerView: 3, // 3 slides for small desktops
					spaceBetween: 30, // Space between slides
				},
				1200: {
					slidesPerView: 4, // 4 slides for larger desktops
					spaceBetween: 30, // Space between slides
				},
			},
		});
	});
</script>

<script>
	$(document).ready(function () {
		$('#qr-code-body').hide().html('');
	   const qrBodyHtml = `
	        <div class="row">
	            <div class="col-md-12">
	                <label class="mt-3 fs-5">Please Scan This QRCode And Then Upload Transaction Screenshot <span class="text-danger">*</span></label>
	                <img src="{{ asset('front/images/GammRaamQrCode.PNG') }}" alt="QR Code" class="barcode_img">
	            </div>
	
	          
	
	            <div class="col-md-12 mt-3">
	                <label>Attachment <span class="text-danger">*</span></label>
	                <input type="file" name="transaction_attachment" id="transaction_attachment" class="form-control" required accept="image/*">
	            </div>
	        </div>`;  
	
	    $('#mode').on('change', function () {
	        const selectedValue = $(this).val();
	
	        if (selectedValue == '2') {
	            $('#qr-code-body').html(qrBodyHtml).show();
	        } else {
	            $('#qr-code-body').hide().html('');
	        }
	    });
	    $('#mode').trigger('change');
	});
</script>
@endpush