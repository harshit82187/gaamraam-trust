@extends('student.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush


<div class="page-content _all_responsive_panel" style="margin-top:-3%;">
    <div class="row">
        <div class="col-12">
            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>
            @endif
        </div>
    </div>
    @if(Auth::guard('student')->user()->state == null || Auth::guard('student')->user()->city == null || Auth::guard('student')->user()->address == null )
    <div class="row">
        <div class="col-12">
            <marquee behavior="scroll" direction="left" style="color: red; font-weight: bold; font-size: 16px;">
                ⚠️ Please first Complete Your Profile!
            </marquee>
        </div>
    </div>
    @endif
    <div class="card card-form-content-box">
        <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
            <h3>Profile</h3>
        </div> <br>
        <div class="card-body ">
            <form action="{{ route('student.profile-update') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        @if(auth()->guard('student')->user()->image)
                        <img src="{{ asset(auth()->guard('student')->user()->image) }}" alt="profile-image" style="margin-bottom: 3%; width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                        @else
                        @if(auth()->guard('student')->user()->gender === 'female')
                        <img src="{{ asset('student/backend/female.png') }}" alt="female-placeholder" style="margin-bottom: 3%; width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                        @else
                        <img src="{{ asset('student/backend/male.jpeg') }}" alt="male-placeholder" style="margin-bottom: 3%; width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                        @endif
                        @endif
                    </div>

                    <div class="col-12 col-md-6 s py-2">
                        <label>Upload Your Profile Image</label>

                        <input type="file" class="form-control" name="image" accept=".jpeg,.jpg,.png" onchange="showSelectedFileName(event)">

                        @error('image')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror

                        {{-- Show Existing File Name --}}
                        @if(!empty(auth()->guard('student')->user()->image))
                        <p class="mt-2" id="fileName" style="color:green; font-size:14px;">
                            {{ auth()->guard('student')->user()->image }}
                        </p>
                        @else
                        <p class="mt-2" id="fileName" style="color:green; font-size:14px;">
                            No file chosen
                        </p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6  py-2">
                        <label>Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" value="{{ auth()->guard('student')->user()->name ?? '' }}" required>
                        @error('name')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 py-2">
                        <label>Email</label><span class="text-danger">*</span>
                        <input type="email" class="form-control" name="email" value="{{ auth()->guard('student')->user()->email ?? '' }}" required>
                        @error('email')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6  py-2">
                        <label>Mobile No</label><span class="text-danger">*</span>
                        <input type="number" class="form-control" name="mobile" value="{{ auth()->guard('student')->user()->mobile ?? '' }}" required>
                        @error('mobile')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 py-2">
                        <label>Date of Birth</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="dob" value="{{ auth()->guard('student')->user()->dob ?? '' }}" required>
                        @error('dob')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4  py-2">
                        <label>Course</label><span class="text-danger">*</span>
                        <select name="course" class="form-control select">
                            <option value="1" {{ auth()->guard('student')->user()->course == '1' ? 'selected' : '' }}>UPSC</option>
                            <option value="2" {{ auth()->guard('student')->user()->course == '2' ? 'selected' : '' }}>SSC</option>

                        </select>
                    </div>

                    <div class="col-12 col-md-4  py-2">
                        <label>Gender</label><span class="text-danger">*</span>
                        <select name="gender" class="form-control select">
                            <option value="">Select Gender</option>
                            <option value="male" {{ auth()->guard('student')->user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ auth()->guard('student')->user()->gender == 'female' ? 'selected' : '' }}>Female</option>

                        </select>
                    </div>
                    <div class="row m-0 p-0">
                        <div class="col-12 col-md-6 py-2">
                            <label>State</label><span class="text-danger">*</span>
                            <select name="state" id="state" class="form-control select2">
                                <option selected disabled>--Select State--</option>
                                @php $states = App\Models\State::where('name', 'Haryana')->get(); @endphp
                                @if($states->isNotEmpty())
                                @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ auth()->guard('student')->user()->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12 col-md-6 py-2">
                            <label>District</label><span class="text-danger">*</span>
                            <select name="city" id="city" class="form-control select2" required>
                                <option selected disabled>--Select District--</option>
                                @php
                                $haryana = App\Models\State::where('name', 'Haryana')->first();
                                $cities = $haryana ? App\Models\City::where('state_id', $haryana->id)->get() : collect([]);
                                @endphp
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ auth()->guard('student')->user()->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row m-0 p-0">
                        <div class="col-12 col-md-6 py-2">
                            <label>Block</label>
                            <select name="block" id="block" class="form-control select2">
                                <option selected disabled>--Select Block--</option>
                                @if(auth()->guard('student')->user()->block)
                                @php
                                $currentBlock = App\Models\Block::where('id', auth()->guard('student')->user()->block)->first();
                                @endphp
                                @if($currentBlock)
                                <option value="{{ $currentBlock->id }}" selected>{{ $currentBlock->name }}</option>
                                @endif
                                @endif
                            </select>
                        </div>

                        <div class="col-12 col-md-6 py-2">
                            <label>Blood Group</label>
                            <select name="blood_group" id="blood_group" class="form-control">
                                <option selected>--Select Blood Group--</option>
                               <option value="A+" {{ auth()->guard('student')->user()->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
								<option value="A−" {{ auth()->guard('student')->user()->blood_group == 'A-' ? 'selected' : '' }}>A−</option>
								<option value="B+" {{ auth()->guard('student')->user()->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
								<option value="B-" {{ auth()->guard('student')->user()->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
								<option value="AB+" {{ auth()->guard('student')->user()->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
								<option value="AB−" {{ auth()->guard('student')->user()->blood_group == 'AB-' ? 'selected' : '' }}>AB−</option>
								<option value="O+" {{ auth()->guard('student')->user()->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
								<option value="O-" {{ auth()->guard('student')->user()->blood_group == 'O-' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-12  py-2">
                        <label>Address</label><span class="text-danger">*</span>
                        <textarea name="address" class="form-control customTextarea " required>{{ auth()->guard('student')->user()->address ?? '' }}</textarea>
                        @error('address')
                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row" style="margin-left:-1%;">
                        <div class="col-12 col-md-6 col-lg-4 col-xl-2 py-2 ">
                            <input type="submit" class="form-control btn btn-primary btn-sm" style="padding:4px;" value="Save Changes">
                        </div>
                    </div>

            </form>



        </div>

    </div>
</div>
</div>
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
    function showSelectedFileName(event) {
        var fileName = event.target.files[0].name;
        document.getElementById('fileName').innerHTML = fileName;
    }
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


<script>
    $(document).ready(function() {

        $('#city, #block').select2();
        // When city changes, fetch corresponding blocks
        $('#city').on('change', function() {
            var cityId = $(this).val();
            var blockSelect = $('#block');


            blockSelect.find('option:not(:first)').remove();

            if (cityId) {

                $.ajax({
                    url: '{{ route("student.get.blocks") }}',
                    type: 'GET',
                    data: {
                        city_id: cityId
                    },
                    success: function(data) {

                        $.each(data, function(index, block) {
                            blockSelect.append(
                                $('<option></option>').val(block.id).text(block.name)
                            );
                        });


                        var currentBlockId = '{{ auth()->guard("student")->user()->block ?? "" }}';
                        if (currentBlockId) {
                            blockSelect.val(currentBlockId).trigger('change');
                        }
                    },
                    error: function() {
                        alert('Error fetching blocks. Please try again.');
                    }
                });
            }
        });


        if ($('#city').val()) {
            $('#city').trigger('change');
        }
    });
</script>

@endpush