@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0">Question Bank</h3>
			<span class="count-circle" style="position:unset;">{{ count($questions ) }}</span>
		</div>

		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Question">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-dark mt-2 mt-sm-0" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-questions">Add </a>
				<a class="btn btn-info v" href="{{ route('admin.question.list') }}">Reset</a>

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
						<th style="width:380px;">Question Name</th>
						<th>Correct</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($questions) > 0)
					@foreach($questions as $question)
					@php
					$options = json_decode($question->options, true);
					$correctAnswer = $options[$question->correct] ?? 'N/A';
					@endphp
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td class="text-nowrap">{{ $question->name ?? '' }}</td>
						<td>
							<label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12" style="white-space: nowrap;cursor: pointer !important;font-size: 17px !important;background-color: rgba(0, 201, 219, .1);position: relative;font-weight: 600 !important;"> {{ $correctAnswer }}</label>
						</td>

						<td class="d-flex align-items-center gap-1" style="height: 92px;">
							<a href="" class="btn btn-primary btn-sm">Edit</a>
							<a href="" class="btn btn-danger btn-sm">Delete</a>

						</td>

					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5" class="text-center">Questions Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $questions->links('pagination::bootstrap-5') }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-questions" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add Question</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.question.add') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- Question Name -->
					<div class="mb-3">
						<label for="name" class="form-label">Question Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Test Series Name" required>
					</div>

					<!-- Option Labels (4 Answer Choices) -->
					<div class="mb-3">
						<label class="form-label">Options <span class="text-danger">*</span></label>
						<input type="text" class="form-control mb-2" name="options[]" placeholder="Option A" required>
						<input type="text" class="form-control mb-2" name="options[]" placeholder="Option B" required>
						<input type="text" class="form-control mb-2" name="options[]" placeholder="Option C" required>
						<input type="text" class="form-control mb-2" name="options[]" placeholder="Option D" required>
					</div>

					<!-- Correct Answer Selection -->
					<div class="mb-3">
						<label for="correct_option" class="form-label">Correct Answer<span class="text-danger">*</span></label>
						<select class="form-control" id="correct" name="correct" required>
							<option value="" disabled selected>Select Correct Answer</option>
							<option value="1">Option A</option>
							<option value="2">Option B</option>
							<option value="3">Option C</option>
							<option value="4">Option D</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="correct_option" class="form-label">Test Series<span class="text-danger">*</span></label>
						<select class="form-control" id="test_series_id" name="test_series_id" required>
							<option value="" disabled selected>---Select Test Series---</option>
							@isset($series)
							@foreach($series as $serie)
							<option value="{{ $serie->id }}">{{ $serie->name ?? 'N/A' }}</option>
							@endforeach
							@endif
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