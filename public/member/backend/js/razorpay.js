$("#donate-online").submit(function(e) {
    console.log("Form submission triggered");
    e.preventDefault();
    let isValid = true;
    var amount = parseInt($('#amount').val(), 10) || 0;
    console.log("Amount is "+amount);   
    if (isValid) {
        console.log("Amount is valid, proceeding with Razorpay");
        razorpaySubmit(this);
      }
});

var razorpayPaymentId = "";
let totalAmount = 0; // Initialize amount
var razorpay_options = {};

function updateRazorpayOptions() {
    let totalAmount = parseInt($('#amount').val(), 10) || 0;
    let totalAmountInPaise = totalAmount * 100;
    console.log("Amount on Razorpay: " + totalAmountInPaise);

    $.ajax({
        url: razorpayInitiateUrl,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        contentType: 'application/json',
        data: JSON.stringify({
            amount: totalAmount,
            name: razorpayUser.name,
            number: razorpayUser.mobile,
            email: razorpayUser.email
        }),
        success: function (data) {
            if (!data.order_id || data.order_id === '') {
                alert("Order ID not received. Payment cannot proceed.");
                return;
            }

            let options = {
                key: data.razorpay_key,
                amount: totalAmountInPaise,
                name: "Gaam Raam",
                description: "Member Donation Via Member Panel (Payment Sidebar)",
                image: razorpay_logo,
                netbanking: true,
                currency: "INR",
                order_id: data.order_id, // ← VERY IMPORTANT to pass
                prefill: {
                    name: razorpayUser.name,
                    email: razorpayUser.email,
                    contact: razorpayUser.mobile
                },
                notes: {
                    donor_name: razorpayUser.name,
                    donor_email: razorpayUser.email,
                    donor_mobile: razorpayUser.mobile,
                    transaction_date: new Date().toISOString()
                },
                theme: { "color": "#ff7029" },
                handler: function (transaction) {
                    console.log("Payment ID: " + transaction.razorpay_payment_id);
                    $('#razorpay_payment_id').val(transaction.razorpay_payment_id);
                    $('#razorpay_order_id').val(transaction.razorpay_order_id);
                    document.getElementById('donate-online').submit();
                },
                modal: {
                    ondismiss: function () {
                        location.reload();
                    }
                }
            };

            let rzp = new Razorpay(options);
            rzp.open();
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            alert("Something went wrong. Please try again.");
        }
    });
}






// Open Razorpay Checkout
var razorpay_instance;
function razorpaySubmit(el) {
    console.log("Opening Razorpay Checkout");
    $('.pay-online').val('Please Wait...').prop('disabled', true);
    updateRazorpayOptions(); 

    if (!razorpay_instance) {
        console.log("Creating new Razorpay instance");
        razorpay_instance = new Razorpay(razorpay_options);
    }
    razorpay_instance.open(); 
}