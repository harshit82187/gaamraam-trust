<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Razorpay</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body onload="launchRazorpay()">
<script>
    function launchRazorpay() {
        var options = {
            key: "{{ env('RAZORPAY_KEY') }}",
            subscription_id: "{{ $subscription_id }}",
            name: "{{ $plan_name }}",
            description: "Plan Subscription For Member Registration through Gaam Raam Employee",
            handler: function (response){
                // Submit to backend with payment details
               fetch("{{ url('admin/razorpay/success-payment') }}", {
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
                        userId: "{{ $userId }}",
                        userName: "{{ $userName }}"
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
                member_id: "{{ $userId }}",
                member_name: "{{ $userName }}",
                member_email: "{{ $email }}",
                member_mobile: "{{ $contact }}",
                admin_id_employee_id: "{{ $admin_id_employee_id }}",
                transaction_date: new Date().toISOString()
            },
            theme: {
                color: "#ff7029"
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
</body>
</html>