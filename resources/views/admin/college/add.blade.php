@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2 select2-container select2-container--default select2-container--below{
        height:46%;
    }
    span.select2.select2-container.select2-container--default {
    width: 100% !important;
}
    .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    font-size: 1rem;
    border-color: #ebedf2;
    padding: 5px 1rem;
    height: 41px !important;
    border-width: 2px;
}
.select2-container--default .select2-selection--single .select2-selection__clear {
    display: none;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 9px;
    right: 10px;
    width: 20px;
}
</style>
@endpush
<div class="page-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add College Details</h4>
                            <a href="{{ url('admin/college-list') }}" class="btn btn-dark btn-sm" >Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
			<div class="card-body">
				<form action="{{ route('admin.college-add') }}" method="POST" enctype="multipart/form-data" >
					@csrf
					<div class="row">
						<div class="col-md-6" style="margin-top: 18px;">
							<label>College Logo <span class="text-danger">* </span></label>
							<input type="file" class="form-control" required name="logo" >
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
					
						<div class="col-md-6" style="margin-top: 18px;">
							<label>College Name <span class="text-danger">* </span></label>
							<input type="text" class="form-control alphabet" required value="{{ old('name') }}" name="name" >
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Establish Year </label>
							<input type="number" class="form-control"  name="year" value="{{ old('year') }}">
                            @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Website Link <span class="text-danger">* </span></label>
							<input type="link" class="form-control" required name="website_link" value="{{ old('website_link') }}">
                            @error('website_link')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Affiliated University  (If applicable) </label>
							<input type="text" class="form-control"  name="affilated_university" value="{{ old('affilated_university') }}">
                            @error('affilated_university')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>College Email </label>
							<input type="email" class="form-control"  name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Mobile Number  </label>
							<input type="text" class="form-control number"  name="mobile_no" value="{{ old('mobile_no') }}">
                            @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>LandLine Number </label>
							<input type="text" class="form-control"  name="landline_no" id="landline_no" value="{{ old('landline_no') }}">
                            @error('landline_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Naac Grade </label>
							<select class="form-control" name="grade"  >
								<option disabled selected >--Select Grade--</option>
								<option value="A++" >A++</option>
								<option value="A+" >A+</option>
								<option value="A" >A</option>
								<option value="B++" >B++</option>
								<option value="B+" >B+</option>
								<option value="B" >B</option>
								<option value="none" >None Of these</option>
							</select>
						</div>
                        @error('grade')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Principal/Director Name <span class="text-danger">* </span></label>
							<input type="text" class="form-control" required name="director_name" value="{{ old('director_name') }}">
                            @error('director_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Pin/Zip Code <span class="text-danger">* </span></label>
							<input type="number" class="form-control" id="pin_code" required name="pin_code" value="{{ old('pin_code') }}">
                            @error('pin_code')
                            <span class="text-danger">{{ $message }}</span>
                             @enderror
						</div>

                        <div class="row">
                            <div class="col-md-4" style="margin-top: 18px;" >
                                <label>State<span class="text-danger">* </span></label>
                                <select name="state" id="state" class="form-control select2"  value="{{ old('state') }}">
                                    <option selected disabled  >--Select State--</option>
                                    @php $states = \App\Models\State::all(); @endphp    
                                    @if(isset($states) && $states->count() > 0)
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" >{{ $state->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4" style="margin-top: 18px;" >
                                <label>City <span class="text-danger ">* </span></label>
                                <select name="city" id="city" class="form-control select2" required  value="{{ old('city') }}">
                                    <option selected disabled>--Select City--</option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div class="col-md-4" style="margin-top: 18px;" >
                                <label>College Location URL </label>
                                <input type="url" class="form-control"  name="location_url" value="{{ old('location_url') }}">
                                @error('location_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
						
						
					
						<div class="col-md-12" style="margin-top: 18px;" >
							<label>Address </label>
							<textarea class="form-control" cols="3" rows="3" name="address" >{{ old('address') }} </textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>
						<div class="col-md-12" style="margin-top: 18px;" >
							<label>Write Somwthing About College </label>
							<textarea class="form-control summernote" cols="8" rows="8" name="description" >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
						</div>

                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>College Video Url</label>
                            <input type="url" class="form-control"  name="video_url" value="{{ old('video_url')  }}">
                            @error('video_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
					
					
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 18px;" >
                                <button type="submit" class="btn btn-primary"  >Submit</button>
                            </div>
                        </div>
						
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
            width:'300px'
        });
    });
</script>
<script>
	$(document).ready(function() {        
	    $('.summernote').summernote({
	    tabsize: 2,
	    height: 120,
	    toolbar: [
	      ['style', ['style']],
	      ['font', ['bold', 'underline', 'clear']],
	      ['color', ['color']],
	      ['para', ['ul', 'ol', 'paragraph']],
	      ['table', ['table']],
	      ['insert', ['link', 'picture', 'video']],
	      ['view', ['fullscreen', 'codeview', 'help']]
	    ]
	   });
	
	});
</script>


<script>
    $(document).ready(function(){        
        $("#state").on('change', function(){
            var stateId = $(this).val();
            console.log(stateId);
            $.ajax({
                url: "{{ url('get-city') }}/"+stateId,
                method : "GET",
                success:function(response){
                    if(response){
                        var dataString = JSON.stringify(response);
                        console.log(dataString);
                        var cityDropdown = $('select[name="city"]');
                        cityDropdown.empty();
                        cityDropdown.append('<option selected disabled>--Select City--</option>');
                        $.each(response, function(index, city) {
                            cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }else{
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

<script>
    $(".alphabet").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z.\s]/g, ''); 
    });

    $("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ''); 
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });

    $("#landline_no").on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ''); 
         if (this.value.length > 15) {
          this.value = this.value.slice(0, 15); 
      }
    });

    $("#pin_code").on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ''); 
         if (this.value.length > 6) {
          this.value = this.value.slice(0, 6); 
      }
    });
</script>
@endpush