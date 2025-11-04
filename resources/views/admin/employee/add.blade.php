@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container{
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single{
        height: 37px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 40px;
    }
</style>
@endpush
<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="mt-3">Add New Employee <span class="count-circle mt-3">{{ count($employees ) }}</span></h3>
	</div>
</div>
<div class="row">
	<div class="col-12">
		@if(session()->get('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session()->get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@if ($errors->any())
		<div class="alert alert-danger alert-dismissible fade show">
			<ul>
				@foreach ($errors->all() as $error)
				<li style="font-size:larger;">{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
</div>

<div class="row">
    <div class="col-12">        
        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>


<div class="card">
	<div class="card-body">
		<form id="employee-store" action="{{ route('admin.employee.store') }}" method="post" enctype="multipart/form-data" class="text-start">
			@csrf                  
			<div class="card">
				<div class="card-body">
					<h5 class="mb-0 page-header-title text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						General information
					</h5>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name"	class="title-color">Full name <span class="text-danger" >*</span>  </label>
								<input type="text" name="name" class="form-control alphabet" id="name"	placeholder="Ex:John Doe" value="" required>
							</div>
							<div class="form-group">
								<label for="phone" class="title-color">Phone <span class="text-danger" >*</span> </label>
								<div class="mb-3">
									<input class="form-control number" name="mobile_no" type="text" id="exampleInputPhone" value=""	placeholder="Enter phone number" required>
								</div>
							</div>
							<div class="form-group">
								<label for="admin_role_id" class="title-color">Role <span class="text-danger" >*</span> </label>
								<select class="form-control" name="admin_role_id" id="admin_role_ids" required>
									<option value="0" selected disabled>Select Role	</option>
                                    @isset($roles)
                                        @foreach($roles as $role)
									        <option	value="{{ $role->id }}" >{{ $role->name ?? 'N/A' }}</option>
                                        @endforeach
                                    @endisset
									
								</select>
							</div>
							<div class="row">
								<div class="col-12 d-none" id="district-container">
									<div class="form-group">
										<label for="city" class="title-color">District <span class="text-danger" >*</span> </label>
										<select class="form-control select select2" name="city" id="city" required>
											<option value="0" selected disabled>Select District</option>	
											@isset($districts)			
												@foreach($districts as $district)
													<option value="{{ $district->id }}">{{ $district->name }}</option>	
												@endforeach
											@endif
										</select>
									</div>
								</div>								
							</div>
							<div class="row">
								<div class="col-12 d-none" id="working-hour-container">
									<div class="form-group">
										<label for="working_hour" class="title-color">Working Hour <span class="text-danger" >*</span> </label>
										<select class="form-control" name="working_hour" id="working_hour" required>
											<option value="0" selected disabled>Select Working Hour	</option>										
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
										</select>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="identify_type" class="title-color">Identify type <span class="text-danger" >*</span> </label>
										<select class="form-control" name="identify_type" id="identify_type" required>
											<option value="" selected disabled>Select identify type</option>
											<option value="1">Aadhar Card</option>
											<option value="2">Pan Card</option>
											<option value="3">Driving License</option>

										</select>
									</div>
								</div>
							</div>
							
							
							<div class="form-group">
								<label for="identify_number" class="title-color">Identify number <span class="text-danger" >*</span> </label>
								<input type="text" name="identify_number" class="form-control"	placeholder="Ex:9876123123" id="identify_number" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<div class="text-center mb-3">
									<img class="upload-img-view" id="viewer"
										src="https://server1.pearl-developer.com/silvana/public/assets/back-end/img/400x400/img2.jpg"
										alt=""/>
								</div>
								<div class="form-group">
									<label for="employee_image">
									Employee Image 
									<small class="text-info">( Ratio 1:1 )</small><span class="text-danger" >*</span> 
									</label>
									<input type="file" name="image" id="image" accept=".jpeg,.jpg,.png,image/jpeg,image/jpg,image/png" required class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="text-center mb-3">
									<img class="upload-img-view" id="viewer2"
										src="https://server1.pearl-developer.com/silvana/public/assets/back-end/img/400x400/img2.jpg"
										alt=""/>
								</div>
								<div class="form-group">
									<label for="identity_image">Identity Image <small class="text-info">( Ratio 1:1 )</small><span class="text-danger" >*</span> </label>
									<input type="file" name="identity_image" id="identity_image" accept=".jpeg,.jpg,.png,image/jpeg,image/jpg,image/png" required class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card mt-3">
				<div class="card-body">
					<h5 class="mb-0 page-header-title d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						Account Information
					</h5>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="email" class="title-color">Email <span class="text-danger" >*</span> </label>
								<input type="email" name="email" autocomplete="one-time-code" class="form-control"	id="email"	placeholder="Ex:ex@gmail.com" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                                <label for="password">Password <span class="text-danger" >*</span> </label>
                                <div class="password-field">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="one-time-code" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#password"></i>
                                </div>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                                <label for="confirmPassword">Confirm Password <span class="text-danger" >*</span> </label>
                                <div class="password-field">
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" autocomplete="one-time-code" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#confirmPassword"></i>
                                </div>
							</div>
                            <span class="text-danger mx-1 password-error"></span>
						</div>
					</div>
					<div class="d-flex justify-content-end gap-3">
						<button type="reset" id="reset" class="btn btn-secondary px-4">Reset</button>
						<button type="submit" id="submit-button" class="btn btn-primary px-4">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<span></span>
		<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
			<form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
				<input type="text" class="form-control filter-name" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Employee Name">
				<select name="admin_role_id"  class="form-control filter-select">
                    <option value="null" selected>All Role</option>
                    @isset($roles)
                        @foreach($roles as $role)
                            <option	value="{{ $role->id }}" >{{ $role->name ?? 'N/A' }}</option>
                        @endforeach
                    @endisset
                </select>
                <button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<button type="submit" name="export" value="1" class="btn btn-dark text-nowrap mt-2 mt-sm-0">Export Excel</button>
				<button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-responsive table-hover">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
						<th class="text-center">Name</th>
						<th class="text-center">Contact Info</th>
						<th class="text-center">Role</th>
						<th class="text-nowrap">All Points</th>
						<th class="text-nowrap">Today Points</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($employees) && $employees->count())
					@foreach($employees as $key => $employee)
					
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td class="text-capitalize">
                            <div class="media align-items-center d-flex gap-3"> 
                                <img class="rounded-circle avatar avatar-lg" alt="{{ asset($employee->image) }}" src="{{ asset($employee->image) }}"  >
                                <a href="{{ route('admin.employee.view',encrypt($employee->id)) }}" target="_blank" title="Employee Information View" class="hover-link">
									<div class="media-body">{{ $employee->name ?? 'N/A' }}</div>
								</a>
                            </div>
                        </td>
						<td class="text-center text-nowrap"> {{ $employee->email ?? 'N/A' }} <br> {{ $employee->mobile_no ?? 'N/A' }} </td>
						<td class="text-center text-nowrap">{{ $employee->role->name ?? 'N/A' }}</td>
						<td class="text-center text-nowrap">{{ $employee->referrals->sum('points') ?? '0' }}</td>
						<td class="text-center text-nowrap">{{ $employee->referrals->where('created_at', '>=', \Carbon\Carbon::today())->sum('points') ?? '0' }}</td>
						<td>
							<label class="switch">
							<input type="checkbox" class="status-toggle" data-id="{{ $employee->id }}" {{ $employee->status ? 'checked' : '' }}>
							<span class="slider round"></span>
							</label> 
						</td>
						<td>
							<!-- <a href="{{ route('admin.employee.edit',$employee->id) }}" class="btn btn-info btn-sm" >Edit</a> -->
							<a href="{{ route('admin.employee.view',encrypt($employee->id)) }}" class="btn btn-dark btn-sm" >View</a>
						</td>
					</tr>
					@endforeach
					@else 
					<tr>
						<td colspan="6" class="text-danger text-center" >No Employee Found!</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $employees->links('pagination::bootstrap-4') }}
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
	$(document).ready(function() {
	   
	    $('.status-toggle').change(function() {
	        var status = $(this).prop('checked') == true ? 1 : 0;
	        var employee_id = $(this).data('id');
	
	        $.ajax({
	            url: '{{ url('admin/employee/status-change') }}',
	            type: 'POST',
	            data: {
	                '_token': $('meta[name="csrf-token"]').attr('content'),
	                'employee_id': employee_id,
	                'status': status
	            },
	            success: function(response) {
	                iziToast.info({
	                    title: 'Info',
	                    message: response.message,
	                    position: 'topRight',
	                    timeout: 3000,
	                });
	            },
	            error: function(xhr, status, error) {
	                iziToast.error({
	                    title: 'Error',
	                    message: 'Error updating status!',
	                    position: 'topRight',
	                    timeout: 4000,
	                    backgroundColor: '#F0D5B6',
	                    titleColor: '#000', 
	                    messageColor: '#000', 
	                    titleSize: '16px',
	                    messageSize: '16px',
	                    titleLineHeight: '20px',
	                    messageLineHeight: '16px',
	                    titleFontWeight: '700', 
	                    messageFontWeight: '700'
	                    });
	            }
	        });
	    });
	    
	});

</script>
<script>
	$(document).on('submit', '#employee-store', function() {
		let btn = $('#submit-button');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
<script>
    $(document).ready(function() {

        function validatePassword(){
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            if(password != confirmPassword){
                $('.password-error').text("Password Do Not Match!");
                $('#submit-button').css('cursor','no-drop').attr('title','Password Do not Match!').prop('disabled',true);
            }else{
                $('.password-error').text("");
                $('#submit-button').prop('disabled',false).css('cursor','pointer');
            }
        }

        $('#confirmPassword').on('keyup',function(){
            validatePassword()
        });

        $('#image').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#viewer').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('#identity_image').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#viewer2').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    document.querySelectorAll('.password-toggle').forEach(function(eyeIcon) {
        eyeIcon.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        });
    });
    $("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });
    $(".alphabet").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
    });
	$('#admin_role_ids').on("change", function () {
		var value = $(this).val();
		console.log(value);
		$('#working-hour-container, #district-container').addClass('d-none');
		if (value == 6) {
			$('#working-hour-container').removeClass('d-none');
		} else if (value == 8) {
			$('#district-container').removeClass('d-none');
		}
	});

</script>
@endpush