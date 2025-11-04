@extends('student.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaaaaa96 !important;
        border-radius: 4px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 37px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endpush


<div class="page-content" style="margin-top:-3%;">
    <div class="row">
        <div class="col-12">
            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>
            @endif
        </div>
    </div>
   


   

            <div class="card mt-5">
                <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                    <h3>Change your password</h3>
                </div>
                <div class="card-body py-2 px-0">
                    <form action="{{ route('student.change-password-process') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6  py-2">
                                <label>New password</label><span class="text-danger">*</span>
                                <input type="password" class="form-control" autocomplete="one-time-code" name="password" required>
                            </div>
                            <div class="col-12 col-sm-6  py-2">
                                <label>Confirm password</label><span class="text-danger">*</span>
                                <input type="password" class="form-control" autocomplete="one-time-code" name="cpassword" required>
                                <span id="password-error" class="text-danger"></span>
                            </div>
                            <div class="col-12 col-md-2 col-lg-4 col-xl-4 py-2">
                                <input type="submit" id="password-submit" class="form-control btn btn-primary btn-sm" style="padding:4px;" value="Save Changes">
                            </div>

                        </div>

                    </form>
                </div>
                 <br><br>
            </div>
            <!-- <div class="row"> -->

            <!-- </div> -->



</div>


<!-- <div class="page-content" style="margin-top:-12%;">
   
</div> -->
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width: '300px'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("input[name='password'], input[name='cpassword']").on("keyup", function() {
            let password = $("input[name='password']").val();
            let confirmPassword = $("input[name='cpassword']").val();
            let submitBtn = $('#password-submit');

            if (password !== confirmPassword || password === "" || confirmPassword === "") {
                submitBtn.prop("disabled", true);
                $('#password-error').html("Password And Confirm Password Do Not Match!");

            } else {
                submitBtn.prop("disabled", false);
                $('#password-error').html("");

            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#state").on('change', function() {
            var stateId = $(this).val();
            console.log(stateId);
            $.ajax({
                url: "{{ url('get-city') }}/" + stateId,
                method: "GET",
                success: function(response) {
                    if (response) {
                        var dataString = JSON.stringify(response);
                        console.log(dataString);
                        var cityDropdown = $('select[name="city"]');
                        cityDropdown.empty();
                        cityDropdown.append('<option selected disabled>--Select District--</option>');
                        $.each(response, function(index, city) {
                            cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    } else {
                        console.error("Empty response received.");
                        alert("Empty response received.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                }
            });
        });
    });
</script>


{{-- <script>
    $(document).ready(function() {
        // Send OTP
        $("#sendOtpBtn").click(function() {
            var email = $("#email").val();
            if (!email) {
                $("#emailMsg").html("Please enter a valid email").css("color", "red");
                return;
            }
            $.ajax({
                url: "{{ route('student.send.otp') }}",
                type: "POST",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $("#sendOtpBtn").text("Sending...").prop("disabled", true);
                },
                success: function(response) {
                    if (response.success) {
                        $("#emailMsg").html(response.message).css("color", "green");
                        $("#otpSection").show();
                    } else {
                        $("#emailMsg").html(response.message).css("color", "red");
                    }
                },
                complete: function() {
                    $("#sendOtpBtn").text("Send OTP").prop("disabled", false);
                },
                error: function() {
                    $("#emailMsg").html("Something went wrong").css("color", "red");
                }
            });
        });

        // Verify OTP
        $("#verifyOtpBtn").click(function() {
            var otp = $("#otp").val();
            if (!otp) {
                $("#otpMsg").html("Please enter OTP").css("color", "red");
                return;
            }
            $.ajax({
                url: "{{ route('student.verify.otp') }}",
                type: "POST",
                data: {
                    otp: otp,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $("#verifyOtpBtn").text("Verifying...").prop("disabled", true);
                },
                success: function(response) {
                    if (response.success) {
                        $("#otpMsg").html(response.message).css("color", "green");
                        location.reload(); // Reload to update verification status
                    } else {
                        $("#otpMsg").html(response.message).css("color", "red");
                    }
                },
                complete: function() {
                    $("#verifyOtpBtn").text("Verify OTP").prop("disabled", false);
                },
                error: function() {
                    $("#otpMsg").html("Invalid OTP!").css("color", "red");
                }
            });
        });
    });
</script> --}}

@endpush