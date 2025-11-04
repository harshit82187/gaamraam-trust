@extends('member.layouts.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Member Profile </h4>
				@if($member->member_id != null)
				<a href="{{ route('member.id-card-download',encrypt($member->member_id)) }}" class="btn btn-dark btn-sm" title="Click to download your ID Card">Download ID Card</a>
				@endif
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<form method="POST" action="{{ route('member.profile')  }}" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					<div class="col-md-12 text-center">
						@if($member->profile_image != null)
						<img class="rounded-circle header-profile-user"  src="{{ asset($member->profile_image) }}" alt="Header Avatar" style="height:96px; width:85px;">                           
						@else 
						<img class="rounded-circle header-profile-user"  src="{{ asset('admin/assets/img/employee.png') }}" alt="Header Avatar" style="height:96px; width:85px;">                           
						@endif
						<div class="mt-2">
							<input type="file" name="profile_image" accept="image/*" class="form-control-file @error('profile_image') is-invalid @enderror"  id="fileInput" style="margin-left:10%">
						</div>
						@error('profile_image')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Name <span class="text-danger">* </span></label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $member->name ?? '' }}" required name="name" >
						@error('name')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Email <span class="text-danger">* </span></label>
						<input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $member->email ?? '' }}"  name="email" >
						@error('email')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Mobile Number  <span class="text-danger">* </span></label>
						<input type="number" class="form-control @error('mobile') is-invalid @enderror" value="{{ $member->mobile ?? '' }}"  id="mobile" name="mobile" >
						@error('mobile')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>DOB</label>
						<input type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ $member->dob ?? '' }}"  name="dob" >
						@error('dob')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					@if($member->country != null)
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Country Name  <span class="text-danger">* </span></label>
						<input type="text" class="form-control @error('country') is-invalid @enderror" value="{{ $member->countryInfo->name ?? '' }}"  readonly>
						@error('country')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Passport No</label>
						<input type="date" class="form-control @error('passport') is-invalid @enderror" value="{{ $member->passport ?? '' }}"  name="passport" readonly >
						@error('passport')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					@endif
					<div class="col-md-2" style="margin-top: 18px;" >
						<label>Blood Group <span class="text-danger">* </span></label>
						<select class="form-select @error('gender') is-invalid @enderror" name="blood_group" required >
							<option disabled selected >--Select Blood Group--</option>
							<option value="A+" {{ $member->blood_group === 'A+' ? 'selected' : '' }} >A+</option>
							<option value="A-" {{ $member->blood_group === 'A-' ? 'selected' : '' }} >A-</option>          
							<option value="B+" {{ $member->blood_group === 'B+' ? 'selected' : '' }} >B+</option> 
							<option value="B-" {{ $member->blood_group === 'B-' ? 'selected' : '' }} >B-</option>
							<option value="AB+" {{ $member->blood_group === 'AB+' ? 'selected' : '' }} >AB+</option>          
							<option value="AB-" {{ $member->blood_group === 'AB-' ? 'selected' : '' }} >AB-</option>  
							<option value="O+" {{ $member->blood_group === 'O+' ? 'selected' : '' }} >O+</option>
							<option value="O-" {{ $member->blood_group === 'O-' ? 'selected' : '' }} >O-</option>                             
						</select>
						@error('blood_group')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-2" style="margin-top: 18px;" >
						<label>Gender <span class="text-danger">* </span></label>
						<select class="form-select @error('gender') is-invalid @enderror" name="gender" required >
							<option disabled selected >--Select Gender--</option>
							<option value="1" {{ $member->gender === '1' ? 'selected' : '' }} >Male</option>
							<option value="2" {{ $member->gender === '2' ? 'selected' : '' }} >Female</option>          
							<option value="3" {{ $member->gender === '3' ? 'selected' : '' }} >Other</option>                           
						</select>
						@error('gender')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-4" style="margin-top: 18px;" >
						<label>District <span class="text-danger">* </span></label>
						<select class="form-select select2 @error('city') is-invalid @enderror" name="city" id="city" required >
							<option selected disabled>--Select District--</option>
							@php
								$haryana = App\Models\State::where('name', 'Haryana')->first();
								$cities = $haryana ? App\Models\City::where('state_id', $haryana->id)->get() : collect([]);
								@endphp
								@foreach($cities as $city)
								<option value="{{ $city->id }}" {{ $member->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
							@endforeach                         
						</select>
						@error('city')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-4" style="margin-top: 18px;" >
						<label>Block <span class="text-danger">* </span></label>
						<select class="form-select select2 @error('block') is-invalid @enderror" name="block" id="block" required >
							<option disabled selected >--Select Block--</option>
							 @php	$currentBlock = App\Models\Block::where('id', $member->block)->first();	@endphp
							@if($currentBlock)
							<option value="{{ $currentBlock->id }}" selected>{{ $currentBlock->name }}</option>
							@endif                        
						</select>
						@error('block')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-12" style="margin-top: 18px;" >
						<label>Address <span class="text-danger">* </span></label>
						<textarea class="form-control " cols="2" rows="2" name="address" >{{ $member->address ?? '' }}</textarea>
						@error('address')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-2" style="margin-top: 18px;" >
						<input type="submit" class="btn btn-primary" id="update-button" value="Update"  >
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="card d-none">
		<div class="card-body">
			<h3>Change Password</h3>
			<form method="POST" action="{{ url('member.profile')  }}" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Password <span class="text-danger">* </span> </label>
						<input type="text" class="form-control" id="password"  name="password" >
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Confirm Password <span class="text-danger">* </span> </label>
						<input type="password" autocomplete="one-time-code" class="form-control" id="cpassword"  >
						<div class="text-danger" id="confirm-password" ></div>
					</div>
					<div class="col-md-2" style="margin-top: 18px;" >
						<input type="submit" class="btn btn-primary" id="update-button2" value="Update"  >
					</div>
			</form>
			</div>
		</div>
	</div>
</div>
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
	$(document).ready(function(){
	    $("#cpassword").on('keyup', function(){
	        var cpassword = $(this).val();
	        var password = $('#password').val();
	        console.log("Password COnfirm :",cpassword);
	
	        if(cpassword != password){
	            $("#confirm-password").html("Password Do Not Match!");
	            $("#update-button2").prop('disabled',true);
	        }else{
	            $("#confirm-password").html("");
	            $("#update-button2").prop('disabled',false);
	
	        }          
	    });
	
	    $("#mobile").on('input', function(){
	        let number = $(this).val();
	        if(number.length >10){
	            number = number.substring(0, 10);
	        }
	        $(this).val(number);
	    });
	
	    $("form").on('submit', function(e) {
	        e.preventDefault();
	        var r= $('<i class="fa fa-spinner fa-spin"></i>');   
	        console.log(r);
	        $("#update-button").html(r).append(' Please Wait...').prop('disabled', true);
	
	        setTimeout(() => {
	            this.submit(); // Submit the form
	        }, 100); // 100 milliseconds delay
	        });
	});
</script>
<script>
    $(document).ready(function() {
        $('#city, #block').select2();
        $('#city').on('change', function() {
            var cityId = $(this).val();
            var blockSelect = $('#block');
            blockSelect.find('option:not(:first)').remove();
            if (cityId) {
                $.ajax({
                    url: '{{ route("get.blocks") }}',
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
                        var currentBlockId = '{{ $member->block ?? "" }}';
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