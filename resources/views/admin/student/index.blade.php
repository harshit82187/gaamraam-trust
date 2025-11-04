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
	<div class="card-header student-enrolls-div">
		<div  style="display: flex; gap: 10px; align-items: center;">
			<img src="{{ asset('admin/assets/img/graduated.png') }}" width="40px" width="40px">
			<h3>Enroll Student's<span class="count-circle" style="margin-top: 0.5%;">{{ count($students ) }}</span></h3>
		</div>		
		<div class="student-enroll-form-div">
			<form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
			<select class="form-control select2 w-100" name="city" style="max-width: 200px;">
				<option value="">--Select City--</option>
				@isset($citys)
					@foreach($citys as $city)
						<option value="{{ $city->id }}" {{ request()->query('city') == $city->id ? 'selected' : '' }}>
							{{ $city->name ?? 'N/A' }}
						</option>
					@endforeach
				@endisset
			</select>
			<input type="text" class="form-control w-100" style="max-width: 200px;" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Student Name">
			<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
			<a class="btn btn-info mt-2 mt-sm-0" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
		</form>

		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-hover table-responsive">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
						<th>Name</th>
						<th>Contact Info</th>
						<th>Registration Mode</th>
						<th>Course</th>
						<th>Enrool Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if($students->count() > 0)
					@foreach($students as $student)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							<a href="{{ route('admin.enrool-student-info',$student->id) }}" style="text-decoration: none;color:#334257;" class="title-color hover-c1 d-flex align-items-center gap-15">
								@if($student->image != null)
								<img src="{{ asset($student->image) }}" class="avatar rounded-circle" height="50px" width="50px" alt="{{ asset($student->image) }}">
								@else
								<img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle" height="50px" width="50px">
								@endif
								{{ $student->name }}
							</a>

						</td>
						<td>
							<div class="mb-1">
								<strong>
									<a href="mailto:{{ $student->email ?? 'N/A' }}" class="title-color hover-c1" style="font-weight:900;color:#334257;">{{ $student->email ?? 'N/A' }}</a>
								</strong>
							</div>
							<a href="tel:{{ $student->mobile ?? 'N/A' }}" style="color:#677788;text-decoration: none;background-color: transparent;cursor: pointer;" class="title-color hover-c1">{{ $student->mobile ?? 'N/A' }}</a><br>
							<span class="title-color hover-c1" style="font-weight:900;color:#334257;">IP Address :</span><a href="javascript:void(0)" style="color:#677788;text-decoration: none;background-color: transparent;cursor: pointer;" class="title-color hover-c1">{{ $student->studentLogDetail->ip ?? 'N/A' }}</a>

						</td>
						<td>
							@if($student->mode == 1)
							By Self
							@elseif($student->mode == 2)
							By College Staff <br>
							@php $instituteMember = \App\Models\Institute::find($student->created_by);
							$college = \App\Models\College::find($instituteMember->college_id);
							@endphp
							{{ $college->name ?? 'N/A' }} <br>
							( {{ $instituteMember->name ?? 'N/A' }} )<br>
							@elseif($student->mode == 3)
							@php $admin = \App\Models\Admin::find($student->created_by);@endphp
							By Admin <br>
							( {{ $admin->name ?? 'N/A' }} )
							@elseif($student->mode == 4)
							@php $member = \App\Models\User::find($student->created_by);@endphp
							By Trust Member <br>
							( {{ $member->name ?? 'N/A' }} )
							@else
							N/A
							@endif
						</td>
						<td>
							@if($student->course == 1)
							UPSC
							@elseif($student->course == 2)
							SSC
							@else
							N/A
							@endif
						</td>
						<td class="white-space: pre;" style="text-wrap-mode:nowrap;">{{ \Carbon\Carbon::parse($student->created_at)->format('d-M-Y') }}</td>
						<td class="d-flex align-items-center gap-1 flex-column" style="height:117px;">
							<a href="">
								<img src="{{ asset('admin/assets/img/mobile.png') }}" height="30px" width="30px">
							</a>
							<a href="{{ route('admin.enrool-student-info',$student->id) }}" class="btn btn-dark btn-sm">View</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7" class="text-danger text-center">No Student Register Yet.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $students->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>
<div class="modal fade" id="add-student" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Student Enrollment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="enrool-student-save-form" action="{{ route('admin.enrool-student-save') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="name" class="form-label">Student Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" placeholder="Enter Student Name" required>
					</div>

					<div class="mb-3">
						<label for="email" class="form-label">Student Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control" name="email" placeholder="Enter Student Email Address" autocomplete="one-time-code" required>
					</div>

					<div class="mb-3">
						<label for="password" class="form-label">Student Password <span class="text-danger">*</span></label>
						<input type="password" class="form-control" name="password" placeholder="Create Student Password " autocomplete="one-time-code" required>
					</div>

					<div class="mb-3">
						<label for="phone" class="form-label">Student Whatsapp Number <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="phone" placeholder="Enter Student  Whatsapp Number" required>
					</div>

					<div class="mb-3">
						<label for="course" class="form-label">Course <span class="text-danger">*</span></label>
						<select class="form-control select" name="course" required>
							<option disabled value="" selected>--Choose Course --</option>
							<option value="1">UPSC</option>
							<option value="2">SSC</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
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
		});
	});
</script>
<script>
	$(document).on('submit', '#enrool-student-save-form', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush