$("input[type='number'], .number").on("input", function() {
    // alert(121);
    this.value = this.value.replace(/[^0-9.]/g, '');
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});

$(".alphabet").on("input", function() {
    this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
});



document.querySelectorAll('.playButton').forEach(function(playButton) {
    playButton.addEventListener('click', function() {
        // Get the parent block and extract the YouTube URL
        var videoBlock = playButton.closest('.video-block');
        var videoUrl = videoBlock.getAttribute('data-video-url');

        // Extract the video ID from the URL (e.g., dQw4w9WgXcQ)
        var videoId = videoUrl.split('v=')[1];

        // Hide the thumbnail and play button in the specific block
        videoBlock.querySelector('.videoThumbnail').style.display = 'none';
        videoBlock.querySelector('.playButton').style.display = 'none';

        // Show the video container and load the video
        videoBlock.querySelector('.videoContainer').style.display = 'block';

        // Set the YouTube iframe src to the embed URL with the video ID
        var iframe = videoBlock.querySelector('.videoIframe');
        iframe.src = 'https://www.youtube.com/embed/' + videoId;

        // Optionally, autoplay the video by adding "?autoplay=1"
        // iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';

        // Hide other video blocks' thumbnails and play buttons, leaving them in their original state
        document.querySelectorAll('.video-block').forEach(function(block) {
            if (block !== videoBlock) {
                // Ensure that other blocks remain unchanged
                block.querySelector('.videoThumbnail').style.display = 'block';
                block.querySelector('.playButton').style.display = 'block';
                block.querySelector('.videoContainer').style.display = 'none';
                block.querySelector('.videoIframe').src = ''; // Stop any video from playing
            }
        });
    });
});

$(document).ready(function() {
    // $("#enrool-now-button").prop("disabled", true);
    $(".otp-number").on("input", function() {
        this.value = this.value.replace(/[^0-9.]/g, '');
        if (this.value.length > 6) {
            this.value = this.value.slice(0, 6);
        }
    });
    $('#enrool-now-button').prop('disabled', true).css('cursor','no-drop').attr('title','First Verify Otp!');

    // $('#enrool-now-button').prop('disabled', true);

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Send OTP
    $("#sendEmailOtpBtn").click(function() {
         let btn = $('#sendEmailOtpBtn');
        var email = $("#email").val();
        if (!email) {
            $("#emailError").text("Please enter an email").css("color", "red");
            return;
        }
        if (!isValidEmail(email)) {
            $("#emailError").text("Please enter a valid email").css("color", "red");
            return;
        }
        $.ajax({
            url: sendOtpRoute,
            type: "POST",
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $("#sendEmailOtpBtn").text("Sending...").prop("disabled", true);
            },
            success: function(response) {
                if (response.success) {
                    $("#emailError").text(response.message).css("color", "green");
                    $("#otpSection").removeClass("d-none");
                    btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');
                    // $('#enrool-now-button').prop('disabled', true);
                } else {
                    $("#emailError").text(response.message).css("color", "red");
                    // $('#enrool-now-button').prop('disabled', true);
                    btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');
                }
            },
            complete: function() {
                $("#sendEmailOtpBtn").text("Send OTP").prop("disabled", false);
                // $('#enrool-now-button').prop('disabled', true);
                btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');
            },
            error: function() {
                $("#emailError").text("Something went wrong. Try again!").css("color", "red");
                // $('#enrool-now-button').prop('disabled', true);
                btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');
            }
        });
    });

    $('#verifyEmailOtpBtn').click(function () {
    let email = $('input[name="email"]').val();
    let otp = $('input[id="emailOtp"]').val();
    console.log("Email Here :" +email);
    console.log("otp Here :" +otp);
    console.log("Verify otp Here :" +verifyOtp);
    $.ajax({
        url: verifyOtp,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            email: email,
            otp: otp
        },
        beforeSend: function() {
            $("#verifyOtpBtn").text("Verifying...").prop("disabled", true);
            // $('#enrool-now-button').prop('disabled', true);
            $('#enrool-now-button').prop('disabled', true).css('cursor','no-drop').attr('title','First Verify Otp!');
        },
        success: function (response) {
            console.log("Response is:" + response.status);
            if (response.status === true) {
                console.log("Hello1");
                $("#otpError").removeClass("text-danger").addClass("text-success").text(response.message);
                $('#enrool-now-button').prop('disabled', false).css('cursor','pointer');
                $("#verifyEmailOtpBtn").hide();
                $('#sendEmailOtpBtn').hide();
                $('input[name="email"]').prop("readonly", true);
                // $('input[name="phone"]').prop("readonly", true);
                $('#emailOtp').prop("readonly", true);
                console.log("Hello2");
               

            } else {
                $("#otpError").removeClass("text-success").addClass("text-danger").text(response.message);
                $("#verifyOtpBtn").text("Verify OTP").prop("disabled", false);
                $('#enrool-now-button').prop('disabled', true).css('cursor','no-drop').attr('title','First Verify Otp!');
            }
        }
    });
});

  
});


$(document).ready(function() {
    let password = $("#password");
    let cpassword = $("#cpassword");
    // var button = $('#enrool-now-button');
    
    cpassword.on('input', function(){
        if(password.val() != cpassword.val()){
            $('#password_error').text("Password Do Not Match");
            // button.prop('disabled', true);
        } else {
            $('#password_error').text("");
            // button.prop('disabled', false);
        }
    });
});


$(document).ready(function () {
    $("#subscriber-form").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        let email = $("#subscriber-email").val().trim();
        let allowedDomains = ["gmail.com", "pearlorganisation.com"];

        if (!isValidEmail(email, allowedDomains)) {
            iziToast.error({
                title: 'Error',
                message: 'Please enter a correct email address!',
                position: 'topRight',
                timeout: 3000,
            });
            return; // Stop execution if email is invalid
        }

        let formData = $(this).serialize(); 

        $.ajax({
            url: "{{ route('subscriber') }}", 
            type: "POST",
            data: formData,
            beforeSend: function () {
                iziToast.info({
                    title: 'Processing',
                    message: 'Please wait...',
                    position: 'topRight',
                });
            },
            success: function (response) {
                iziToast.success({
                    title: 'Success',
                    message: 'Subscription successful!',
                    position: 'topRight',
                });
                $("#subscriber-form")[0].reset(); // Reset the form
            },
            error: function (xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'Something went wrong!',
                    position: 'topRight',
                });
            }
        });
    });

    function isValidEmail(email, allowedDomains) {
        let domain = email.split("@").pop();
        return allowedDomains.includes(domain);
    }
});


// 29-03-2025 @arun js donate 

// donation counter start
	document.addEventListener("DOMContentLoaded", function () {
    function animateCounter(id, target) {
        let element = document.getElementById(id);
        if (!element) {
            console.error("Element with ID '" + id + "' not found.");
            return;
        }

        let count = 0;
        let speed = target / 100;
        let interval = setInterval(() => {
            count += speed;
            element.innerText = '₹' + Math.floor(count);
            if (count >= target) {
                element.innerText = '₹' + target;
                clearInterval(interval);
            }
        }, 20);
    }


    animateCounter("received", actualreceivedAmount);
    animateCounter("spent", spentAmount);
    animateCounter("remaining", remainingBalance);
});


	// donation counter end

	// member section start
	



    function toggleview() {
		var content = document.getElementById("showcontent");
		var button = document.getElementById("toggleviewbtn");

		if (content.style.display === "none") {
			content.style.display = "block";
			button.innerHTML = "See Less";
		} else {
			content.style.display = "none";
			button.innerHTML = "See More";
		}
	}



	function toggleContent() {
		var content = document.getElementById("member-show");
		var button = document.getElementById("member-toggle");

		if (content.style.display === "none") {
			content.style.display = "block";
			button.innerHTML = "See Less";
		} else {
			content.style.display = "none";
			button.innerHTML = "See More";
		}
	}



    function togglecontent() {
		var contt = document.getElementById("show-content");
		var btnnn = document.getElementById("view-toggle");

		if (contt.style.display === "none") {
			contt.style.display = "block";
			btnnn.innerHTML = "See Less";
		} else {
			contt.style.display = "none";
			btnnn.innerHTML = "See More";
		}
	}


    var swiper = new Swiper(".mySwiper", {
		slidesPerView: 3,
		grid: {
			rows: 2,
		},
		spaceBetween: 30,
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
	});


    var swiper = new Swiper(".swiper-member", {
		slidesPerView: 2,
		spaceBetween: 30,
		loop: true,
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
		navigation: {
		    nextEl: ".swiper-button-next",
		    prevEl: ".swiper-button-prev",
		},
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

    document.addEventListener("DOMContentLoaded", function() {
		document.querySelectorAll(".playButton").forEach(function(button) {
			button.addEventListener("click", function() {
				let videoBlock = this.closest(".video-block");
				let videoContainer = videoBlock.querySelector(".videoContainer");
				let videoIframe = videoBlock.querySelector(".videoIframe");
				let videoUrl = videoBlock.getAttribute("data-video-url");

				// Convert YouTube Shorts link to Embed format
				if (videoUrl.includes("shorts")) {
					videoUrl = videoUrl.replace("youtube.com/shorts/", "youtube.com/embed/");
				} else {
					videoUrl = videoUrl.replace("watch?v=", "embed/");
				}

				videoIframe.src = videoUrl + "?autoplay=1"; // Auto-play the video
				videoContainer.style.display = "block";
			});
		});
	});



    document.addEventListener("DOMContentLoaded", function () {
        var swiper1 = new Swiper('.member-swiper-container', {
            loop: true,
            centeredSlides: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 0 },
                768: { slidesPerView: 3, spaceBetween: 10 },
                1024: { slidesPerView: 4, spaceBetween: 10 }
            }
        });
    
        
        var swiper2 = new Swiper(".college-swiper", {
            slidesPerView: 2,
            spaceBetween: 10,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 10 },
                640: { slidesPerView: 1, spaceBetween: 20 },
                768: { slidesPerView: 2, spaceBetween: 40 },
                1024: { slidesPerView: 3, spaceBetween: 50 },
                1199: { slidesPerView: 3, spaceBetween: 50 },
            },
        });
    });






// 03-04-2025 @arun js 
document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper('.swiper-ap', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        breakpoints: {
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
});



// 03-04-2025 @arun become-a-member js

document.querySelectorAll(".custom-tab").forEach(tab => {
    tab.addEventListener("click", function() {
        document.querySelectorAll(".custom-tab").forEach(t => t.classList.remove("active"));
        document.querySelectorAll(".custom-tab-content").forEach(content => content.classList.remove("active"));

        this.classList.add("active");
        document.getElementById(this.dataset.tab).classList.add("active");
    });
});


document.addEventListener("DOMContentLoaded", function() {
    let tabs = document.querySelectorAll('.point-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            let tabId = this.getAttribute('data-tab');

            document.querySelectorAll('.point-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.point-tab-content').forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    document.querySelector('.point-tab').classList.add('active');
});


function toggleview() {
    var content = document.getElementById("showcontent");
    var button = document.getElementById("toggleviewbtn");

    if (content.style.display === "none") {
        content.style.display = "block";
        button.innerHTML = "See Less";
    } else {
        content.style.display = "none";
        button.innerHTML = "See More";
    }
}











// 03-04-2025 @arun js member-register page
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

$(".alphabet").on("input", function() {
    this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
});




// send otp via whatsapp 21-04-2025 @harshit

$('#sendOtpBtn').click(function () {
    let phone = $('input[name="phone"]').val();
    let btn = $('#sendOtpBtn');
    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    if (phone === '') {
        alert('Please enter your WhatsApp number first.');
        btn.html('Get OTP On WhatsApp').prop('disabled', false).css('cursor', 'pointer');
        return;
    }

    if (phone.length < 10) {
        alert('Please Enter You 10 digit Whatsapp Number.');
        btn.html('Get OTP On WhatsApp').prop('disabled', false).css('cursor', 'pointer');
        return;
    }

    $.ajax({
        url:sendOtpWhatsappRoute,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            mobile: phone
        },
        success: function (response) {
            if (response.status) {
                $('#whatsappotpSection').removeClass('d-none');
                // alert('OTP sent to your WhatsApp number');
                $('#sendOtpError').text("");
                btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');

            } else {
                // alert(response.message);
                $('#sendOtpError').text(response.message);
                btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');

            }
        },
        error: function (xhr) {
            $('#sendOtpError').text(response.message);
            btn.html('Send Again').prop('disabled', false).css('cursor', 'pointer');

        }
    });
});

$('#whatsappVerifyOtpBtn').click(function () {
    let phone = $('input[name="phone"]').val();
    let otp = $('input[name="whatsappOtp"]').val();
   
    
    $.ajax({
        url: verifyWhatsappOtp,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            mobile: phone,
            otp: otp
        },
        beforeSend: function() {
            $("#whatsappVerifyOtpBtn").text("Verifying...").prop("disabled", true);
            // $('#enrool-now-button').prop('disabled', true);
            $('#enrool-now-button').prop('disabled', true).css('cursor','no-drop').attr('title','First Verify Otp!');
        },
        success: function (response) {
            console.log("Response is:" + response.status);
            if (response.status) {
                $("#whatsappotpError").removeClass("text-danger").addClass("text-success").text(response.message);
                $('#enrool-now-button').prop('disabled', false).css('cursor','pointer');
                $("#verifyOtpBtn").hide();
                $('#whatsappVerifyOtpBtn').hide();
                $('input[name="email"]').prop("readonly", true);
                $('input[name="phone"]').prop("readonly", true);
                $('#otp').prop("readonly", true);
               

            } else {
                $("#whatsappotpError").removeClass("text-success").addClass("text-danger").text(response.message);
                $("#whatsappVerifyOtpBtn").text("Verify OTP").prop("disabled", false);
                $('#enrool-now-button').prop('disabled', true).css('cursor','no-drop').attr('title','First Verify Otp!');
            }
        }
    });
});

$(document).on('submit', '#contact-us', function(e) {
    e.preventDefault();
    var captchaResponse = grecaptcha.getResponse();
        if (captchaResponse.length === 0) {
        $('#captchaError').text('Please complete the CAPTCHA.');
        return; 
    } else {
        $('#captchaError').text('');
    }
    let btn = $('button[type="submit"]');
    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
        .prop('disabled', true)
        .css('cursor', 'no-drop');
    setTimeout(function() {
        $('#contact-us')[0].submit();  
    }, 1000);
});


$(document).ready(function() {
    $("#email").on("copy cut paste", function(e) {
        e.preventDefault();
    });
    $("#email").on("keyup", function() {
        validateEmail();
    });
    function validateEmail() {
        let email = $("#email").val().trim();
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
                    } else {
                        $("#regEmailError").text("");
                    }
                }
            });
        }
    }
});


$(document).on('submit', '#sumit-contact-form', function(e) {
    e.preventDefault(); 
    var captchaResponse = grecaptcha.getResponse();
    if (captchaResponse.length === 0) {
    $('#captchaError').text('Please complete the CAPTCHA.');
        return; 
    } else {
            $('#captchaError').text('');
            $('.send-message').html('Please Wait...');
            $('#sumit-contact-form')[0].submit();  
    }

});



// 27-06-2025 m@harshit get-member-by-city
$(document).ready(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('select[name="city"]').on('change', function () {
			var cityId = $(this).val();
			if (cityId) {
				$.ajax({
					url: getMemberByCityRoute + cityId,
					type: "GET",
					dataType: "json",
					success: function (response) {
						$('#district-member-wrapper').html(response.html);

						if (typeof Swiper !== 'undefined') {
							new Swiper('.member-swiper-container', {
								slidesPerView: 3,
								spaceBetween: 30,
								loop: true,
								autoplay: {
									delay: 3000,
									disableOnInteraction: false,
								},
							});
						}
					},
					error: function (xhr) {
						let msg = 'Something went wrong!';
						if (xhr.responseJSON?.message) {
							msg = xhr.responseJSON.message;
						}
						alert(msg);
					}
				});
			}
		});
	});
