$(document).on('submit', '#forget-password-form', function(e) {
    e.preventDefault();
   
    let btn = $(this).find('button[type="submit"]');
    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
        .prop('disabled', true);
    this.submit();
}); 



$(document).ready(function() {
    $('.donate_amount').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#member-login-form").on("submit", function(e) {
        e.preventDefault(); // Prevent default form submission
        let btn = $("#member-login-button");
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true);

        $.ajax({
            url: memberLoginRoute,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    iziToast.info({
                        title: 'Success',
                        message: 'Login successful!',
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
                        timeout: 3000,
                        backgroundColor: '#F0D5B6'
                    });
                    $("#login-form-error").html(`<div>${response.message}</div>`).show();
                    btn.html('Login').prop('disabled', false);
                }
            },
            error: function(xhr) {
                let errorDiv = $("#login-form-error");
                errorDiv.hide().html(""); // Clear previous errors
            
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsgArray = Object.values(errors).flat();
                    let errorMsgHtml = errorMsgArray.map(msg => `<div>${msg}</div>`).join("");
            
                    // Show in iziToast
                    iziToast.error({
                        title: 'Validation Error',
                        message: errorMsgArray.join("<br>"),
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#F0D5B6'
                    });
            
                    // Show above the form
                    errorDiv.html(errorMsgHtml).show();
                    btn.html('Login').prop('disabled', false);
                } else {
                    let genericMsg = 'An unexpected error occurred.';
            
                    iziToast.error({
                        title: 'Error',
                        message: genericMsg,
                        position: 'topRight',
                        timeout: 3000,
                        backgroundColor: '#F0D5B6'
                    });
            
                    errorDiv.html(`<div>${genericMsg}</div>`).show();
                    btn.html('Login').prop('disabled', false);
                }
            }
            
        });
    });
});





$(document).ready(function() {
    $(document).on("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#regEmail, #regMobile, #referral_code").on("copy cut paste", function(e) {
        e.preventDefault();
    });
    $(document).keydown(function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'x' || e.key === 'v')) {
            e.preventDefault();
        }
    });

    function validateEmail() {
        let email = $("#regEmail").val().trim();
        console.log("Email :" + email);
        if (email !== "") {
            $.ajax({
                url: validateEmailRoute,
                type: "POST",
                data: {
                    email: email,
                   '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {

                    if (response.status === "error") {
                        $("#regEmailError").text(response.message);
                        $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop');
                    } else {
                        $("#regEmailError").text("");
                        checkSubmitButton();
                    }
                }
            });
        }
    }

    function validateMobile() {
        let mobile = $("#regMobile").val().trim();
        var currency = $('#razorpay_currency').val();
        let isIndian = currency === "INR";

        let mobileRegex = isIndian ? /^\d{10}$/ : /^\d{10,15}$/;
        let minLength = isIndian ? 10 : 10;
        let maxLength = isIndian ? 10 : 15;
        $("#regMobile").attr("minlength", minLength).attr("maxlength", maxLength);

        console.log("Mobile: " + mobile);
        console.log("currency: " + currency);
        if (mobile !== "" && mobileRegex.test(mobile)) {
            $.ajax({
                url: validateMobileNoRoute,
                type: "POST",
                data: {
                    mobile: mobile,
                   '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    console.log(response);                     
                    if (response.status === 'error' && response.exists) {
                        $("#regMobileError").text(response.message);
                        $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop');
                    } else {
                        $("#regMobileError").text("");
                        checkSubmitButton();
                    }
                }
            });
        } else {
            $("#regMobileError").text("Enter a valid mobile number (10-15 digits).");
            $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop');
        }
    }

    function checkSubmitButton() {
        if ($("#regEmailError").text() === "" && $("#regMobileError").text() === "") {
            $("#regSubmit").prop("disabled", false).css('cursor', 'pointer');
        } else {
            $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop');
        }
    }

    function validatePassword(){
        var password = $('#regPassword').val();
        var cpassword = $('#regCPassword').val();
        if(password != cpassword){
            $('#regCPassword-error').text("Password Do Not Match!");
            $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop').attr('title','Password Do Not Match!');
            console.log("Password Do Not Match!");
        }else{
            $('#regCPassword-error').text("");
            $("#regSubmit").prop("disabled", false).css('cursor', 'pointer');
            console.log("Password Do Not Match!");
        }
    }

    function validateReferralCode() {
        let referral_code = $("#referral_code").val().trim().toUpperCase();
        $("#referral_code").val(referral_code); 

        if (referral_code === "") {
            $("#regReferralCodeError").text("");
            $("#regSubmit").prop("disabled", false).css('cursor', 'pointer');
            return;
        }

        $.ajax({
            url: validateReferralCodeRoute,
            type: "POST",
            data: {
                referral_code: referral_code,
                '_token': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.status === "error") {
                    $("#regReferralCodeError").text(response.message);
                    $("#regSubmit").prop("disabled", true).css('cursor', 'no-drop');
                } else {
                    $("#regReferralCodeError").text("");
                    checkSubmitButton();
                }
            }
        });
    }

    $("#regEmail").on("keyup", function() {
        validateEmail();
    });

    $("#regMobile").on("keyup", function() {
        validateMobile();
    });

    $('#regCPassword').on("keyup", function() {
        validatePassword();
    });

    $('#referral_code').on("keyup", function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
        validateReferralCode();
    });


});




$(document).ready(function() {   
        $('#amount').val(100);
        $('#razorpay_currency').val("INR");    
   
        $('input[name="member_type"]').change(function() {
            if ($('#nri').is(':checked')) {
                $('#passport-field').show();
                $('#country-field').show();
                $('#passport').attr('required', true);
                $('#country').attr('required', true);
                $('#amount').val(10);
                $('#amount-label').html(window.translations.amount_minimum_payable_10_usd);
                $('#monthly-membership-label').html("Monthly Membership (10 USD per month)");
                $('#yearly-membership-label').html("Yearly Membership (110 USD per year)");
                $('#razorpay_currency').val("USD");
            } else {
                $('#passport-field').hide();
                $('#passport').removeAttr('required');
                $('#passport').val('');
                $('#amount').val(100);
                $('#amount-label').html(window.translations.amount_minimum_payable_100);
                $('#monthly-membership-label').html("Monthly Membership (100 Rupees per month)");
                $('#yearly-membership-label').html("Yearly Membership (1100 Rupees per year)");
                $('#razorpay_currency').val("INR");
            }
        });
        $('#passport').on('copy paste cut', function(e) {
            e.preventDefault();
        });

         const planBodyHtml = `
            <div class="mt-2">
                <label>Select Membership Type</label><br>
                <div class="select-membership d-flex">
                    <input type="radio" name="plan" value="1" checked required>
                    <label id="monthly-membership-label">Monthly Membership (₹100/month)</label><br>
                </div>
                <div class="select-membership d-flex">
                    <input type="radio" name="plan" value="2">
                    <label id="yearly-membership-label">Yearly Membership (₹1100/year)</label>
                </div>
                <p>${yourBankMessage}</p>
            </div>`;

        // QR Code Body HTML
        const qrBody = `
            <div class="row">
                <label class="mt-3 fs-5">Please Scan This QRCode And Then Upload Transaction Screenshot <span class="text-danger">*</span></label>
                <img src="${baseUrl}" alt="QR Code" class="barcode_img">

                <div class="col-md-6 mt-3">
                    <label>Amount <span class="text-danger">*</span></label>
                    <input type="text" name="donate_amount" id="donate_amount" placeholder="Enter Your Donate Amount" class="form-control donate_amount" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Attachment <span class="text-danger">*</span></label>
                    <input type="file" name="attachment" id="attachment" required accept="image/*">
                </div>
            </div>`;

         $('#plan-body').html(planBodyHtml).show();
         $('#qr-code-body').hide().html('');

        $('#mode').on('change', function () {
            const value = $(this).val();

            if (value == 3) {
                $('#qr-code-body').html(qrBody).show();
                $('#plan-body').hide().html('');
            } else if (value == 1) {
                $('#plan-body').html(planBodyHtml).show();
                $('#qr-code-body').hide().html('');
            } else {
                $('#qr-code-body').hide().html('');
                $('#plan-body').hide().html('');
            }
        });
        $('input[name="member_type"]:checked').trigger('change');
    
});




$(document).on('submit', '#register-form', function(e) {
    e.preventDefault(); // Prevent default form submission
    var captchaResponse = grecaptcha.getResponse();
    if (captchaResponse.length === 0) {
    $('#captchaError').text('Please complete the CAPTCHA.');
        return; 
    } else {
        $('#captchaError').text('');
    }
    let selectedCurrency = $('#razorpay_currency').val();
    let minAmount = selectedCurrency === "INR" ? 100 : 10;
    let mode = $('#mode').val();
    console.log("Mode Value Submit Time :" +mode);

    function showError(input, message) {
        isValid = false;
        console.log('Validation Error:', message);
        $(`<span class="text-danger error-msg">${message}</span>`).insertAfter(input);
    }

    const fieldsToValidate = [
            { selector: 'input[name="plan"]', name: 'Membership Plan' },
            { selector: 'input[name="donate_amount"]', name: 'Donate Amount' },
            { selector: 'input[name="attachment"]', name: 'attachment' },
        ];

    fieldsToValidate.forEach(field => {
        const input = $(field.selector);
        if (!input.val()) {
            console.log(`Field: ${field.selector}, Message: ${field.name} is required`);
            showError(input, `${field.name} is required`);
        }
    });

    if (mode == '1') {
        const planSelected = $('input[name="plan"]:checked').val();
        if (!planSelected) {
            showError($('#plan-body'), 'Please select a membership plan');
             return; 
        }
    } else if (mode == '3') {
        const amount = $('input[name="donate_amount"]').val();
        const attachment = $('input[name="attachment"]').val();
        if (!amount) {
            showError($('input[name="donate_amount"]'), 'Amount is required');
             return; 
        }
        if (!attachment) {
            showError($('input[name="attachment"]'), 'Transaction Attachment is required');
             return; 
        }
    }

    

    let btn = $('#register-form').find('button[type="submit"]');
    const loader = document.getElementById("paymentLoader");
    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
        .prop('disabled', true);
    loader.style.display = "flex";
    if (mode == 1) {
        $(this)[0].submit(); 
        // razorpaySubmit(); 
    } else {
        $(this)[0].submit(); 
    }      
});

var razorpayPaymentId = "";
var totalAmount = 0;

function updateRazorpayOptions() {
    let totalAmount = parseInt($('#amount').val(), 10) || 0;
    let totalAmountInPaise = totalAmount * 100;
    console.log("Total Amount: ", totalAmount);
    console.log("Amount in Paise: ", totalAmountInPaise); // Debugging the amount

    let selectedCurrency = $('#razorpay_currency').val();
    console.log("Selected Currency: ", selectedCurrency); // Debugging the currency

    // alert("Total Amount in Paise: " + totalAmountInPaise);
    return {
        key: RAZORPAY_KEY,
        amount: totalAmountInPaise,
        name: "Gaam Raam",
        description: "Member Donation",
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
        theme: {
            color: "#ff7029"
        },
        handler: function(transaction) {
            razorpayPaymentId = transaction.razorpay_payment_id;
            console.log("Payment ID: " + razorpayPaymentId);
            $('#razorpay_payment_id').val(razorpayPaymentId);
            document.getElementById('register-form').submit();
        },
        modal: {
            ondismiss: function() {
                location.reload();
            }
        }
    };
}

// Open Razorpay Checkout
function razorpaySubmit() {
    console.log("Opening Razorpay Checkout");
    $('.pay-online').val('Please Wait...').prop('disabled', true);

    let razorpay_options = updateRazorpayOptions();
    let razorpay_instance = new Razorpay(razorpay_options);

    razorpay_instance.open();
}


document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('regPassword');
    const eyeIcon = this.querySelector('i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});

document.getElementById('toggleCPassword').addEventListener('click', function() {
    const confirmPasswordField = document.getElementById('regCPassword');
    const eyeIcon = this.querySelector('i');
    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        confirmPasswordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});


document.getElementById('toggleLoginPassword').addEventListener('click', function() {
    const passwordField = document.getElementById('loginPassword');
    const eyeIcon = this.querySelector('i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});



