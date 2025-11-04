@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-flex gap-2 align-items-center">
			<h3>Courses</h3>
			<span class="count-circle" style="position:unset;">{{ count($courses ) }}</span>
		</div>

		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class=" gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Course Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				{{-- <a class="btn btn-dark" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-course" style="width:51%;">Add Course</a> --}}
				<a class="btn btn-info" href="{{ route('admin.courses') }}">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
						<th>Course Name</th>
						<th>Image</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($courses) > 0)
					@foreach($courses as $course)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							{{ $course->name ?? '' }}
						</td>
						<td>
							@if($course->image == null)
							<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px">
							@else
							<a href="{{ asset($course->image) }}" target="_blank">
								<img src="{{ asset($course->image)  }}" height="50px" width="50px">
							</a>
							@endif
						</td>

						<td>
							<label class="switch">
								<input type="checkbox" class="status-toggle" data-id="{{ $course->id }}" {{ $course->status ? 'checked' : '' }}>
								<span class="slider round"></span>
							</label>
						</td>
						<td>
							<a href="{{ route('admin.edit-course',$course->id) }}" class="btn btn-warning btn-sm">Edit</a>
						</td>

					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5" class="text-center">Course's Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $courses->links() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-course" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="width:165%;margin-left:-27%">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add Course</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.add-course') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="name" class="form-label">Course Name</label><span class="text-danger">*</span>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Course Name" required>
					</div>
					<!-- Image Upload Field -->
					<div class="mb-3">
						<label for="image" class="form-label">Upload Image</label><span class="text-danger">*</span>
						<input type="file" class="form-control" id="image" name="image" required accept="image/*">
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
</script>

@endpush