$(document).ready(function() {   
    $('#amount').val(100);
    $('#amount-label').html("Amount (Minimum payable amount is 100 Rupees)");
    $('#razorpay_currency').val("INR");    
    $('input[name="member_type"]').change(function() {
        if ($('#nri').is(':checked')) {
            $('#passport').attr('required', true);
            $('#amount').val(10);
            $('#amount-label').html("Amount (Minimum payable amount is 10 USD)");
            $('#razorpay_currency').val("USD");
        } else {
            $('#passport-field').hide();
            $('#passport').val('');
            $('#amount').val(100);
            $('#amount-label').html("Amount (Minimum payable amount is 100 Rupees)");
            $('#razorpay_currency').val("INR");
        }
    });
});

$("#enroll-member").submit(function(e) {
    console.log("Form submission triggered");
    e.preventDefault();
    let isValid = true;
    let amount = parseFloat($('#amount').val()) || 0;
    let selectedCurrency = $('#razorpay_currency').val();
    let minAmount = selectedCurrency === "INR" ? 100 : 10;
    let mode = $('#mode').val();
    console.log("Amount is "+amount);
    console.log("Currency is "+selectedCurrency);
   
    if (amount < minAmount) {
        iziToast.info({
            title: 'Info',
            message: `Minimum payable amount is ${minAmount} ${selectedCurrency === "INR" ? "Rupees" : "USD"}`,
            position: 'topRight',
            timeout: 3000,
        });
        isValid = false;
        return;
    }
    if (isValid) {
        if (mode == 1) {
            console.log("Amount is valid, proceeding with Razorpay");
            razorpaySubmit(this);
        }else{
            console.log("Amount is valid, proceeding with offline mode");
            $(this)[0].submit(); 
        }
      }
});


var razorpayPaymentId = "";
let totalAmount = 0; // Initialize amount
var razorpay_options = {};
function updateRazorpayOptions() {
    totalAmount = parseInt($('#amount').val(), 10) || 0;
    let totalAmountInPaise = totalAmount * 100;
    console.log("Amount on Razorpay: " + totalAmountInPaise);
    let selectedCurrency = $('#razorpay_currency').val();
    console.log("Amount on Razorpay: " + totalAmountInPaise + " " + selectedCurrency);
    // Now razorpay_options exists, so we can modify its properties
    razorpay_options = {
        key: RAZORPAY_KEY,
        amount: totalAmountInPaise, // Fixed: Already converted to paise
        name: "Gaam Raam",
        description: "Member Enrool Via Member Pannel",
        image: razorpay_logo,
        netbanking: true,
        currency: selectedCurrency,
        prefill: {
            name: $('#regName').val(),
            email: $('#regEmail').val(),
            contact: $('#regMobile').val()
        },
        notes: {
            donor_name: $('#regName').val(),
            donor_email: $('#regEmail').val(),
            donor_mobile: $('#regMobile').val(),
            transaction_date: new Date().toISOString()
        },
        theme: { "color": "#ff7029" },
        handler: function (transaction) {
            razorpayPaymentId = transaction.razorpay_payment_id;
            console.log("Payment ID: " + razorpayPaymentId);
            document.getElementById('razorpay_payment_id').value = razorpayPaymentId;
            document.getElementById('enroll-member').submit(); // Correct form ID
        },
        modal: {
            ondismiss: function () {
                location.reload();
            }
        }
    };
}



// Open Razorpay Checkout
var razorpay_instance;
function razorpaySubmit(el) {
    console.log("Opening Razorpay Checkout");
    $('.submit-button').val('Please Wait...').prop('disabled', true);
    updateRazorpayOptions(); 

    if (!razorpay_instance) {
        console.log("Creating new Razorpay instance");
        razorpay_instance = new Razorpay(razorpay_options);
    }
    razorpay_instance.open(); 
}