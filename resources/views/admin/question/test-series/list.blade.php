@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3>Test Series</h3>
			<span class="count-circle" style="position:unset;">{{ count($testSeries ) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0"  value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Test Series Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-dark mt-2 mt-sm-0" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-series" >Add </a>
				<a class="btn btn-info mt-2 mt-sm-0"  onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table table-striped align-middle table-nowrap table-hover">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
						<th>Test Series Name</th>
						<th>Total Question</th>
						<th>Duration (In Minute)</th>
						<th>Attempt Date & Time</th>
						{{-- <th>Status</th> --}}
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($testSeries) > 0)
					@foreach($testSeries as $course)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							@if($course->image == null)
							<img src="{{ asset('front/images/no-image.jpg') }}" style="width:20%;height:auto;border-radius:22px;">
							@else
							<a href="{{ asset($course->image) }}" target="_blank">
								<img src="{{ asset($course->image)  }}" style="width:20%;height:auto;border-radius:22px;">
							</a>
							@endif
							{{ $course->name ?? '' }}
						</td>
						<td>
							<label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12" style="white-space: nowrap;cursor: pointer !important;font-size: 17px !important;background-color: rgba(0, 201, 219, .1);position: relative;font-weight: 600 !important;">4</label>
						</td>
						<td>{{ $course->duration }} Min</td>
						<td>{{ \Carbon\Carbon::parse($course->attempt_date_time)->format('d M Y, h:i A') }}</td>
						{{-- <td>
									<label class="switch">
										<input type="checkbox" class="status-toggle" data-id="{{ $course->id }}" {{ $course->status ? 'checked' : '' }}>
						<span class="slider round"></span>
						</label>
						</td> --}}
						<td class="d-flex gap-1 align-items-center " style="height: 92px;">
							<a href="javascript:void(0)" class="btn btn-primary btn-sm edit-series" data-name="{{ $course->name }}" data-id="{{ $course->id }}" data-duration="{{ $course->duration }}" data-attempt_date_time="{{ $course->attempt_date_time }}"
								data-image="{{ $course->image }}">Edit</a>
							<button onclick="deleteSeries({{ $course->id }})" class="btn btn-danger btn-sm">Delete</button>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5" class="text-center">Test Series Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $testSeries->links() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-series" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add Test Series</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.test-series.add') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="name" class="form-label">Series Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Test Series Name" required>
					</div>
					<div class="mb-3">
						<label for="image" class="form-label">Upload Image <span class="text-danger">*</span></label>
						<input type="file" class="form-control" id="image" name="image" required accept="image/*">
					</div>
					<div class="mb-3">
						<label for="duration" class="form-label">Duration (in minutes) <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="duration" name="duration" placeholder="Enter duration in minutes" required min="1">
					</div>
					<div class="mb-3">
						<label for="duration" class="form-label">Test Series Attempt Date & Time <span class="text-danger">*</span></label>
						<input type="datetime-local" class="form-control" id="attempt_date_time" name="attempt_date_time" required>
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


{{-- Edit Modal --}}
<div class="modal fade" id="edit-series" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Edit Test Series</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.test-series.edit') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">

					<div class="mb-3">
						<label for="name" class="form-label">Series Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Test Series Name" required>
					</div>

					<div class="mb-3">
						<label for="image" class="form-label">Upload Image (If you want) </label>
						<input type="file" class="form-control" id="image" name="image" accept="image/*">
					</div>
					<div class="mb-3">
						<label for="duration" class="form-label">Duration (in minutes) <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="duration" name="duration" placeholder="Enter duration in minutes" required min="1">
					</div>
					<div class="mb-3">
						<label for="duration" class="form-label">Test Series Attempt Date & Time <span class="text-danger">*</span></label>
						<input type="datetime-local" class="form-control" id="attempt_date_time" name="attempt_date_time" required>
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
	$(document).ready(function() {
		$("#duration").on("input", function() {
			this.value = this.value.replace(/[^0-9]/g, '');
		});
	});
</script>

<script>
	$(document).ready(function() {
		let now = new Date();
		let year = now.getFullYear();
		let month = String(now.getMonth() + 1).padStart(2, '0');
		let day = String(now.getDate()).padStart(2, '0');
		let hours = String(now.getHours()).padStart(2, '0');
		let minutes = String(now.getMinutes()).padStart(2, '0');
		let minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
		$("#attempt_date_time").attr("min", minDateTime);
	});
</script>

<script>
	$('.edit-series').on('click', function(e) {
		e.preventDefault();
		var id = $(this).data('id');
		var name = $(this).data('name');
		var duration = $(this).data('duration');
		var image = $(this).data('image');
		var attempt_date_time = $(this).data('attempt_date_time');
		$('#edit-series').modal('show');
		console.log("id :" + id);
		$('#edit-series').find('input[name="id"]').val(id);
		$('#edit-series').find('input[name="name"]').val(name);
		$('#edit-series').find('input[name="duration"]').val(duration);
		$('#edit-series').find('input[name="attempt_date_time"]').val(attempt_date_time);
	});

	function deleteSeries(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: '',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Delete',
			customClass: {
				popup: 'swal2-large',
				content: 'swal2-large'
			}
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "{{ route('admin.test-series.delete', ':id') }}".replace(':id', id);
			}
		});
	}
</script>

{{-- <script>
	$(document).ready(function() {
		$('.status-toggle').change(function() {
			var status = $(this).prop('checked') == true ? 1 : 0;
			var course_id = $(this).data('id');

			$.ajax({
				url: '{{ url('admin/course-update-status') }}',
type: 'POST',
data: {
'_token': $('meta[name="csrf-token"]').attr('content'),
'course_id': course_id,
'status': status
},
success: function(response) {
iziToast.info({
title: 'Info',
message: 'Course status updated successfully!',
position: 'topRight',
timeout: 3000,
});
},
error: function(xhr, status, error) {
iziToast.error({
title: 'Error',
message: 'Error updating status!',
position: 'topRight',
timeout: 3000
});
}
});
});
});
</script> --}}

@endpush