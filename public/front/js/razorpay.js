
    $(".number").on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ''); 
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });

    $(".alphabet").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
    });


    $("#donate-online").submit(function(e) {
        console.log("Form submission triggered");
        e.preventDefault();
        let isValid = true;
      
        var amount = parseInt($('#amount').val(), 10) || 0;
         var mode = $('#mode').val();
        if (amount <= 0) {
            iziToast.info({
                title: 'Info',
                message: 'Amount Not Be Below Zero rupees!',
                position: 'topRight',
                timeout: 3000,
            });
            isValid = false;
        }
         $('#paymentLoader').removeClass('d-none');
        if (isValid) {
            if (mode === "1") {
            console.log("Razorpay mode selected, proceeding with Razorpay");
                razorpaySubmit(this);
            } else {
                console.log("Offline mode selected, submitting form normally");
                $(this).off('submit').submit();
            }
        }
    });

    var razorpayPaymentId = "";
    let totalAmount = 0; // Initialize amount
    function updateRazorpayOptions() {
        totalAmount = parseInt($('#amount').val(), 10) || 0;
        let totalAmountInPaise = totalAmount * 100;        
        console.log("Amount on Razorpay: " + totalAmountInPaise);
    
        // Get dynamic input values
        var donerName = $('#name').val() || 'Unknown Donor';
        var mobile_no = $('#mobile_no').val() || '0000000000';
        var email = $('#donor_email').val() || 'unknowndonoremail@gmail.com';
        console.log("Prefill Values - Name:", donerName, "Email:", email, "Mobile:", mobile_no);

        $.ajax({
            url: razorpayInitiateUrl,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            contentType: 'application/json',
            data: JSON.stringify({
                amount: totalAmount,
                name: donerName,
                number: mobile_no,
                email: email
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
                    description: "User Donation Via Website Donation Page",
                    image: razorpay_logo,
                    netbanking: true,
                    currency: "INR",
                    order_id: data.order_id, // ← VERY IMPORTANT to pass
                    prefill: {
                        name: donerName,
                        email: email,
                        contact: mobile_no
                    },
                    notes: {
                        donor_name: donerName,
                        donor_email: email,
                        donor_mobile: mobile_no,
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
        let btn = $('#donate-now-submit');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
        updateRazorpayOptions(); 

        if (!razorpay_instance) {
            console.log("Creating new Razorpay instance");
            razorpay_instance = new Razorpay(razorpay_options);
        }
        razorpay_instance.open(); 
    }