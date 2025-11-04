@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="page-content">
	<div class="container-fluid">
		@include('admin.notification.menu')
	</div>
</div>
<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-flex gap-2 align-items-center">
			<h3>Notifications</h3>
			<span class="count-circle" style="position: unset;">{{ count($notifications ) }}</span>
		</div>

		<div class="d-flex gap-2 align-items-center">
			<a class="btn btn-primary mt-1 mt-sm-0" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#send-notification">Send Notification</a>
			<button class="btn btn-info mt-1 mt-sm-0" onclick="window.location.href='{{ url()->current() }}';">Reset</button>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped table-responsive">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
						<th>Student Name</th>
						<th>Image</th>
						<th>Subject</th>
						<th>Description </th>
						<th>Action </th>
					</tr>
				</thead>
				<tbody>
					@if(count($notifications) > 0)
					@foreach($notifications as $notification)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							@if(is_array($notification->students))
							{{ !empty($notification->students) ? implode(', ', $notification->students) : 'No Students Assigned' }}
							@else
							{{ $notification->students }}
							@endif
						</td>
						<td>
							@if($notification->image == null)
							<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px">
							@else
							<a href="{{ asset($notification->image) }}" target="_blank">
								<img src="{{ asset($notification->image) }}" height="50px" width="50px">
							</a>
							@endif
						</td>
						<td>{{ $notification->subject }}</td>
						<td>{{ Illuminate\Support\Str::limit(strip_tags($notification->description), 65) }}
							<i class="fa fa-info-circle" data-toggle="tooltip" title="{{ strip_tags($notification->description) }}"></i>
						</td>
						<td>
							<a href="javascript:void(0)" data-id="{{ $notification->id }}" data-subject="{{ $notification->subject }}" data-description="{{ strip_tags($notification->description) }}" class="btn btn-dark btn-sm view-button">View</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6" class="text-center text-danger">Notification's Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $notifications->links() }}
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="send-notification" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Send Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.send-notification') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- Subject Field -->
					<div class="mb-3">
						<label for="subject" class="form-label">Student Name<span class="text-danger">*</span></label>
						<select class="form-control select2" name="student_id[]" multiple required>
							<option disabled>--Select Student--</option>
							<option value="0">All Student</option>
							@if(isset($students))
							@foreach($students as $student)
							<option value="{{ $student->id }}">{{ $student->name }}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="mb-3">
						<label for="subject" class="form-label">Subject<span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" required>
					</div>
					<!-- Image Upload Field -->
					<div class="mb-3">
						<label for="image" class="form-label">Upload Image</label>
						<input type="file" class="form-control" id="image" name="image" accept="image/*">
					</div>
					<!-- Description Field -->
					<div class="mb-3">
						<label for="description" class="form-label">Description<span class="text-danger">*</span></label>
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
<div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">View Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label for="subject" class="form-label">Subject</label>
					<input type="text" class="form-control" id="subject-show" name="subject" readonly>
				</div>
				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="description-show" name="description" rows="4" readonly></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		if ($('.select2').length > 0) {
			$('.select2').select2({
				allowClear: true,
				dropdownParent: $('#send-notification')
			});

			$('#send-notification').on('shown.bs.modal', function() {
				$('.select2').select2({
					allowClear: true,
					dropdownParent: $('#send-notification')
				});
			});
			$('.select2').on('change', function(e) {
				let selectedValues = $(this).val();
				if (selectedValues && selectedValues.includes("0")) {
					$(this).val(["0"]).trigger("change.select2");
				} else if (selectedValues && selectedValues.length > 1) {
					let filteredValues = selectedValues.filter(value => value !== "0");
					$(this).val(filteredValues).trigger("change.select2");
				}
			});
		}
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
	$('.view-button').on('click', function() {
		// alert(121);
		var id = $(this).data('id');
		var subject = $(this).data('subject');
		var description = $(this).data('description');
		console.log("Subject : " + subject);
		console.log("Description : " + description);
		$('#notification-modal').modal('show');
		$('#subject-show').val(subject);
		$('#description-show').val(description);


	});
</script>
@endpush