@extends('front.layout.app')
@section('content')
<style>
    input.form-control {
        height: 52px !important;
        /* Adjust as needed */
        line-height: 1.5;
    }


    .loader-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
        color: white;
    }

    .loader {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<br><br>
<div class="container">

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
                <p>Processing Payment, Please Wait...</p>
            </div>
            <div class="registeration-form-member ">
                <div id="registration-form" class="form-container active registration-form">
                    <h2>Register</h2>

                    <form id="register-form" action="{{ route('member-register') }}" method="post">
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="transaction_via" value="razorpay">
                        <input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
                        <input type="hidden" name="currency" id="razorpay_currency">
                        @csrf
                        <div>
                            <label for="">Name</label><span class="text-danger">*</span>
                            <input type="text" class="alphabet" name="name" id="regName" value="{{ old('name') }}" autocomplete="one-time-code" placeholder="Enter Your Name" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Email</label><span class="text-danger">*</span>
                            <input type="email" name="email" id="regEmail" value="{{ old('email') }}" placeholder="Enter Your Email" oncopy="return false" oncut="return false" onpaste="return false" autocomplete="one-time-code" required>
                            <span id="regEmailError" class="text-danger"></span>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Mobile Number</label><span class="text-danger">*</span>
                            <input type="text" name="mobile" id="regMobile" value="{{ old('mobile') }}" oncopy="return false" oncut="return false" onpaste="return false" placeholder="Enter Your Mobile Number" autocomplete="one-time-code" required>
                            <span id="regMobileError" class="text-danger"></span>
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <label>Member Type</label><span class="text-danger">*</span>
                            <div class="d-flex align-items-center gap-2 mx-3">
                                <input type="radio" name="member_type" id="indian" checked value="1" required>
                                <label for="indian">Indian</label>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <input type="radio" name="member_type" id="nri" value="2" required>
                                <label for="nri">NRI</label>
                            </div>
                        </div>
                        <div id="passport-field" style="display:none;">
                            <label>Passport No</label><span class="text-danger">*</span>
                            <input type="text" name="passport" id="passport" placeholder="Enter Your Passport No" autocomplete="one-time-code">
                            @error('passport')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Password</label><span class="text-danger">*</span>
                            <div class="password-container">
                                <input type="password" name="password" id="regPassword" placeholder="Enter Your Password" autocomplete="one-time-code" required>
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
                            <label>Confirm Password</label><span class="text-danger">*</span>
                            <div class="password-container">
                                <input type="password" name="cpassword" id="regCPassword" placeholder="Enter Your Confirm Password" autocomplete="one-time-code" required>
                                <span class="eye-icon" id="toggleCPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- <div>
                            <label>Confirm Password</label><span class="text-danger">*</span>
                            <input type="password" name="cpassword"  placeholder="Enter Your Confirm Password" autocomplete="one-time-code" required>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> -->
                        <div>
                            <label id="amount-label">Amount (Minimum payable amount is 100 rupees)</label><span class="text-danger">*</span>
                            <input type="number" name="amount" id="amount" autocomplete="one-time-code" required>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" id="regSubmit">Register</button>
                    </form>
                    <div class="link-member">
                        <p>Already have an account? <a href="javascript:void(0);" onclick="showLoginForm()">Login</a></p>
                    </div>
                </div>

                <div id="login-form" class="form-container login-form">
                    <h2>Login</h2>
                    <form id="member-login-form">
                        @csrf
                        <input type="email" name="email" placeholder="Enter Your Email" required>
                        <div class="login-password-container">
                            <label>Password</label><span class="text-danger">*</span>
                            <div class="password-container">
                                <input type="password" name="password" id="loginPassword" placeholder="Enter Your Password" required>
                                <span class="eye-icon" id="toggleLoginPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <!-- <input type="password" name="password" placeholder="Enter Your Password" required> -->
                        <button type="submit" id="member-login-button">Login</button>
                    </form>
                    <div class="link-member">
                        <p>Forgot your password? <a href="javascript:void(0);" onclick="showForgotPasswordForm()">Forgot Password</a></p>
                        <p>Don't have an account? <a href="javascript:void(0);" onclick="showRegistrationForm()">Register</a></p>
                    </div>
                </div>

                <div id="forgot-password-form" class="form-container">
                    <h2>Forgot Password</h2>
                    <form id="forget-password-form" action="{{ route('forget-password') }}" method="POST">
                        @csrf
                        <input type="email" id="forgotEmail" name="email" autocomplete="one-time-code" placeholder="Enter Your Email" required>
                        <button type="submit">Reset Password</button>
                    </form>
                    <div class="link-member">
                        <p>Remembered your password? <a href="javascript:void(0);" onclick="showLoginForm()">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- <div class="row my-5">
        <h1>Memebers</h1>
        <div class="swiper mySwiper member-swiper">
            <div class="swiper-wrapper">
                @php $members = \App\Models\User::where('status','1')->get(); @endphp
                @foreach ($members as $member)
                <div class="swiper-slide">
                    <div class="member-card">
                        <div class="member-image">
                            @if($member->profile_image)
                            <a href="{{ route('member-detail',$member->id) }}">
                                <img src="{{ asset($member->profile_image) }}" style="width: 100%; height: 100%;" alt="{{ asset($member->profile_image) }}">
                            </a>
                            @else
                            <a href="{{ route('member-detail',$member->id) }}">
                                <img src="{{ asset('front/images/avatar-01.jpg') }}" style="width: 100%; height: 100%;" alt="{{ asset('app/courses/2025/Feb/1740647495.jpg') }}">
                            </a>
                            @endif
                        </div>
                        <div class="member-card-body">
                            <div class="member-tittle">
                                <h4>{{ $member->name ?? '' }}</h4>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @endforeach
              
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div> -->
    <div class="row">
        <h2 class="h1 py-2 text-center">Member Details</h2>
    </div>
    <div class="row py-5">
        <div class="">
            <div class="swiper-member">
                <div class="swiper-wrapper">
                    @php $members = \App\Models\User::where('status','1')->get(); @endphp
                    @isset($members)
						@foreach($members as $member)
                            <div class="swiper-slide">
                                <div class="process-content-teacher member-card-div">
                                    <div class="student-image-block py-2">
                                        @if($member->image != null)
                                        <img src="{{ asset($member->image) }}" alt="{{ asset($member->image) }}" />
                                        @else
                                        <img src="{{ asset('front/images/boy.png') }}" alt="{{ asset('front/images/boy.png') }}" />
                                        @endif
                                    </div>
                                    <h3 class="h4 py-2">{{ $member->name ?? 'N/A' }}</h3>
                                    <p class="mb-0">Soical Point :- 1000</p>
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


@endsection

@push('js')

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 5,
        spaceBetween: 30,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            1024: {
                slidesPerView: 5,
            },
            768: {
                slidesPerView: 3,
            },
            480: {
                slidesPerView: 2,
            },
            320: {
                slidesPerView: 1,
            }
        }
    });
</script>

<script>
    // Ensure functions are globally accessible
    function showRegistrationForm() {
        document.getElementById("registration-form").classList.add("active");
        document.getElementById("login-form").classList.remove("active");
        document.getElementById("forgot-password-form").classList.remove("active");
    }

    function showLoginForm() {
        document.getElementById("login-form").classList.add("active");
        document.getElementById("registration-form").classList.remove("active");
        document.getElementById("forgot-password-form").classList.remove("active");
    }

    function showForgotPasswordForm() {
        document.getElementById("forgot-password-form").classList.add("active");
        document.getElementById("login-form").classList.remove("active");
        document.getElementById("registration-form").classList.remove("active");
    }

    // Automatically show login form if redirected from authentication middleware
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('showLogin'))
        showLoginForm();
        @endif
    });
</script>

<script>
   

    $(".alphabet").on("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });


    $(document).on('submit', '#forget-password-form', function() {
        let btn = $('#forget-password-form').find('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
            .prop('disabled', true);
    });
</script>

<script>
 
</script>



<!-- Include iziToast CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#member-login-form").on("submit", function(e) {
            e.preventDefault(); // Prevent default form submission
            let btn = $("#member-login-button");
            btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true);

            $.ajax({
                url: "{{ route('member-login') }}",
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
                        btn.html('Login').prop('disabled', false);

                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = Object.values(errors).flat().join("<br>");

                        iziToast.error({
                            title: 'Validation Error',
                            message: errorMsg,
                            position: 'topRight',
                            timeout: 4000,
                            backgroundColor: '#F0D5B6'
                        });
                        btn.html('Login').prop('disabled', false);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'An unexpected error occurred.',
                            position: 'topRight',
                            timeout: 3000,
                            backgroundColor: '#F0D5B6'
                        });
                        btn.html('Login').prop('disabled', false);
                    }
                }
            });
        });
    });
</script>

<script>
    var swiper = new Swiper(".swiper-member", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        // navigation: {
        //     nextEl: ".swiper-button-next",
        //     prevEl: ".swiper-button-prev",
        // },
        breakpoints: {
            1024: {
                slidesPerView: 4
            },
            768: {
                slidesPerView: 3
            },
            575: {
                slidesPerView: 2
            },

            0: {
                slidesPerView: 1
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Disable right-click
        $(document).on("contextmenu", function(e) {
            e.preventDefault();
        });

        // Disable copy, cut, paste
        $("#regEmail, #regMobile").on("copy cut paste", function(e) {
            e.preventDefault();
        });

        // Disable Ctrl+C, Ctrl+X, Ctrl+V
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
                    url: "{{ route('validate-email') }}",
                    type: "POST",
                    data: {
                        email: email,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        if (response.status === "error") {
                            $("#regEmailError").text(response.message);
                            $("#regSubmit").prop("disabled", true);
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
            var currency =  $('#razorpay_currency').val();
            let isIndian = currency === "INR";

            let mobileRegex = isIndian ? /^\d{10}$/ : /^\d{10,15}$/;
            let minLength = isIndian ? 10 : 10;
            let maxLength = isIndian ? 10 : 15;
            $("#regMobile").attr("minlength", minLength).attr("maxlength", maxLength);

            console.log("Mobile: " + mobile);
            console.log("currency: " + currency);
            if (mobile !== "" && mobileRegex.test(mobile)) {
                $.ajax({
                    url: "{{ route('validate-mobile') }}",
                    type: "POST",
                    data: {
                        mobile: mobile,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.exists) {
                            $("#regMobileError").text("This mobile number is already taken.");
                            $("#regSubmit").prop("disabled", true);
                        } else {
                            $("#regMobileError").text("");
                            checkSubmitButton();
                        }
                    }
                });
            } else {
                $("#regMobileError").text("Enter a valid mobile number (10-15 digits).");
                $("#regSubmit").prop("disabled", true);
            }
        }

        function checkSubmitButton() {
            if ($("#regEmailError").text() === "" && $("#regMobileError").text() === "") {
                $("#regSubmit").prop("disabled", false);
            } else {
                $("#regSubmit").prop("disabled", true);
            }
        }

        $("#regEmail").on("keyup", function() {
            validateEmail();
        });

        $("#regMobile").on("keyup", function() {
            validateMobile();
        });
    });
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

    $(document).ready(function() {
        $(document).ready(function(){
            $('#amount').val(100); 
            $('#razorpay_currency').val("INR");
        });
        $('input[name="member_type"]').change(function() {
            if ($('#nri').is(':checked')) {
                $('#passport-field').show();
                $('#passport').attr('required', true);
                $('#amount').val(10); 
                $('#amount-label').html("Amount (Minimum payable amount is 10 USD)");
                $('#razorpay_currency').val("USD");
            } else {
                $('#passport-field').hide();
                $('#passport').removeAttr('required');
                $('#passport').val('');
                $('#amount').val(100); 
                $('#amount-label').html("Amount (Minimum payable amount is 100 Rupees)");
                $('#razorpay_currency').val("INR");
            }
        });
        $('#passport').on('copy paste cut', function(e) {
            e.preventDefault();
        });
    });
    
    $(document).on('submit', '#registration-form', function(e) {
        e.preventDefault(); // Prevent default form submission
        let amount = parseFloat($('#amount').val()) || 0;
        let selectedCurrency = $('#razorpay_currency').val();
        let minAmount = selectedCurrency === "INR" ? 100 : 10; 

        if (amount < minAmount) {
            iziToast.error({
                title: 'Error',
                message: `Minimum payable amount is ${minAmount} ${selectedCurrency === "INR" ? "Rupees" : "USD"}`,
                position: 'topRight',
                timeout: 5000
            });
            return; // Stop execution
        }

        let btn = $('#registration-form').find('button[type="submit"]');
        const loader = document.getElementById("paymentLoader");
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
            .prop('disabled', true);
        loader.style.display = "flex"; // Show loader


        razorpaySubmit();
    });

    var razorpayPaymentId = "";
    let totalAmount = 0;

    function updateRazorpayOptions() {
        totalAmount = parseInt($('#amount').val(), 10) || 0;
        let totalAmountInPaise = totalAmount * 100;
        console.log("Amount on Razorpay: " + totalAmountInPaise);
        let selectedCurrency = $('#razorpay_currency').val(); // Get selected currency
        console.log("Amount on Razorpay: " + totalAmountInPaise + " " + selectedCurrency);

        return {
            key: "{{ env('RAZORPAY_KEY') }}",
            amount: totalAmountInPaise,
            name: "Gaam Raam",
            description: "Member Donation",
            image: "{{ asset('front/images/Gaam_Raam_logo.png') }}",
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
</script>

<!-- for register password eye icon -->
<script>
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
</script>

<!-- for login eye icon -->
<script>
    document.getElementById('toggleLoginPassword').addEventListener('click', function () {
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
</script>
@endpush