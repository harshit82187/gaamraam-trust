@extends('front.layout.app')
@section('content')
@push('css')
@endpush
<div id="paymentLoader" class="payment-loader-overlay d-none">
	<p class="payment-processing">⏳ Processing Payment, Please Wait...</p>
</div>
<section class="hero">

</section>
<main class="container">
	<div class="row justify-content-center mt-5">
		<div class="payment-container">
			<h2>💸 Pay Securely with Razorpay</h2>
			<p>📝 Enter your details and click the button below to proceed.</p>
			<form action="{{ route('proccedd-to-pay') }}" id="proccedd-to-pay" method="POST">
				@csrf
				<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
				<input type="hidden" name="transaction_via" value="razorpay">
				<input type="hidden" name="email" value="harshit@gmail.com">
				<input type="hidden" name="mobile_no" value="1234567890">
				<input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
				<input type="text" name="amount" id="amount" placeholder="💰 Enter Amount" class="payment-number" required>
				<button id="pay-now" type="submit">💳 Pay Now</button>
			</form>
		</div>
	</div>
</main>
@endsection
@push('js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	var razorpay_logo = "{{ asset('front/img/faviconn.ico') }}";
	var RAZORPAY_KEY = "{{ env('RAZORPAY_KEY') }}";
	var proccedRoute = "{{ route('proccedd-to-pay') }}";
</script>
<script src="{{ asset('front/js/razorpay.js') }}"></script>
<script>
	$('.payment-number').on('input', function () {
	    this.value = this.value.replace(/[^0-9]/g, '');
	});

	$(document).on('submit', 'form', function () {
	    $('button[type="submit"]').text('🔄 Please Wait...').prop('disabled', true);
	});
</script>
<script>
    $(document).ready(function(){


    $("#proccedd-to-pay").submit(function(e){
        e.preventDefault();
        console.log("Amount is valid, proceeding with Razorpay");
        razorpaySubmit();
    });

    var razorpayPaymentId = "";
    let RtotalAmount = 0; // Initialize amount
    function updateRazorpayOptions(newAmount = null) {
        let RtotalAmount = newAmount ? newAmount : parseFloat($("#amount").val());
        let totalAmountInPaise = RtotalAmount * 100;

        console.log("Updated Amount on Razorpay: " + totalAmountInPaise);
        razorpay_options.amount = totalAmountInPaise.toString();
    }

    // Razorpay options
    var razorpay_options = {
        key: RAZORPAY_KEY,
        amount: RtotalAmount * 100,
        name: "Tensor",
        description: "Property Booking",
        image:razorpay_logo,
        netbanking: true,
        currency: "INR",
        prefill: {
            name: "Harshit Chauhan",
            email: "harshitk@pearlorganisation.com",
            contact: "1234567890"
        },
        "theme": { "color": "#012549" },
        handler: function (transaction) {
            razorpayPaymentId = transaction.razorpay_payment_id;
            console.log("Payment ID: " + razorpayPaymentId);
            document.getElementById('razorpay_payment_id').value = razorpayPaymentId;
            document.getElementById('proccedd-to-pay').submit();

        },
        modal: {
            ondismiss: function () {
                location.reload();
            }
        }
    };

    // Open Razorpay Checkout
    var razorpay_instance;
    function razorpaySubmit(el) {
        console.log("Opening Razorpay Checkout");
        $('#pay-now').val('Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
        $('#paymentLoader').removeClass('d-none');
        updateRazorpayOptions();

        if (!razorpay_instance) {
            console.log("Creating new Razorpay instance");
            razorpay_instance = new Razorpay(razorpay_options);
        }
        razorpay_instance.open();
    }



});

</script>
@endpush
