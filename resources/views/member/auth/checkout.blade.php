@extends('front.layout.app')
@section('content')
<div id="paymentLoader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
    <p>⏳ Processing Payment, Please Wait...</p>
</div>

@endsection 

@push('js')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const loader = document.getElementById("paymentLoader");
    loader.style.display = "flex";
    function launchRazorpay() {
        var options = {
            key: "{{ env('RAZORPAY_KEY') }}",
            subscription_id: "{{ $subscription_id }}",
            name: "{{ $plan_name }}",
            description: "Plan Subscription",
            handler: function (response){
                // Submit to backend with payment details
                fetch('/razorpay/payment-success', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.razorpay_payment_id,
                        subscription_id: "{{ $subscription_id }}",
                        plan_name: "{{ $plan_name }}",
                        plan_id: "{{ $plan_id }}",
                        plan_amount: "{{ $amount }}",
                        interval: "{{ $interval }}",
                        email: "{{ $email }}",
                        contact: "{{ $contact }}",
                        userName: "{{ $userName }}",
                        userId: "{{ $userId }}"
                    })
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "thank-you?payment_id=" + response.razorpay_payment_id;
                    } else {
                        alert('Something went wrong');
                    }
                });
            },
            prefill: {
                email: "{{ $email }}",
                contact: "{{ $contact }}"
            },
            notes: {
                member_donor_name: "{{ $userName }}",
                member_donor_email: "{{ $email }}",
                member_donor_user_id: "{{ $userId }}",
                transaction_date: new Date().toISOString()
            },
            theme: {
                color: "#528FF0"
            },
            method: {
                netbanking: true,
                card: true,
                upi: true,
                wallet: true
            },
            remember_customer: false
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
    launchRazorpay();
</script>
@endpush