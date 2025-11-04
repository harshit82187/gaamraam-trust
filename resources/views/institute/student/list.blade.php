@extends('institute.layout.app')
@section('content')
@push('css')

@endpush
<div class="card">
	<div class="card-header tax-header">
		<div class="d-flex " style="gap: 10px;">
			<h3>Enroll Student's</h3>
			<span class="count-circle" style="position: unset;">{{ count($students ) }}</span>
		</div>

		<div class="enroll-student-dash">
			<form action="{{ url()->current() }}" method="get">
				<input type="text" class="form-control " value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Student Name">
				<button class="btn btn-primary">Search</button>
				<a class="btn btn-dark" data-bs-target="#add-student" data-bs-toggle="modal" >Add Student</a>
				{{-- <a href="{{ route('institute.student-data-district-wise') }}" class="btn btn my-district" style="width:89%;">Students in My District</a> --}}
				<a class="btn btn-info" href="{{ url('institute/enrool-student') }}">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>S No.</th>
						<th>Name</th>
						<th>Mobile No</th>
						<th>Email </th>
						<th>Course</th>
						<th>Enrool Date</th>
						{{-- <th>Action</th> --}}
					</tr>
				</thead>
				<tbody>
					@if(count($students) > 0)
					@foreach($students as $student)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $student->name }}</td>
						<td>{{ $student->mobile }}</td>
						<td>{{ $student->email }}</td>
						<td>
							@if($student->course == 1)
							UPSC
							@elseif($student->course == 2)
							SSC
							@else
							N/A
							@endif
						</td>
						<td>{{ \Carbon\Carbon::parse($student->created_at)->format('d-M-Y') }}</td>
						{{-- <td>
								<a href="{{ route('admin.enrool-student-info',$student->id) }}" class="btn btn-dark btn-sm" >View</a>
						</td> --}}

					</tr>
					@endforeach
					@else
					<tr>
						<td class="text-center" colspan="6">No Student Found</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="send-notification" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content w-100">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Send Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.send-notification') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- Subject Field -->
					<input type="hidden" name="student_id">
					<div class="mb-3">
						<label for="subject" class="form-label">Subject</label><span class="text-danger">*</span>
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" required>
					</div>
					<!-- Image Upload Field -->
					<div class="mb-3">
						<label for="image" class="form-label">Upload Image</label>
						<input type="file" class="form-control" id="image" name="image" accept="image/*">
					</div>
					<!-- Description Field -->
					<div class="mb-3">
						<label for="description" class="form-label">Description</label><span class="text-danger">*</span>
						<textarea class="form-control summernote" id="description" name="description" rows="4" placeholder="Enter description" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Send Notification</button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="add-student" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content w-100">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Student Enrollment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="enrool-student-save-form" action="{{ route('institute.enrool-student-save') }}" method="POST" enctype="multipart/form-data">
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
<script>
	$(document).on('submit', '#enrool-student-save-form', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
<script>
	$(document).ready(function() {
		// alert(121);
		$('.notification').on('click', function() {
			var id = $(this).data('id');
			var email = $(this).data('email');

			$('#send-notification').modal('show');
			$('#modalLabel').html('Send Notification : ' + email);
			$('#send-notification').find('input[name="student_id"]').val(id);


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
@endpush