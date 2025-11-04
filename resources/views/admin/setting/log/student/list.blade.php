@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
	a.title-color:hover {
	color: #0177cd !important;
	}
	.select2-container{
	width: 100% !important;
	}
	.select2-container--default .select2-selection--single{
	height: 37px !important;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
	line-height: 35px;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow {
	top: 7px;
	}
	.select2-container--default .select2-selection--single .select2-selection__clear {
	cursor: pointer;
	float: right;
	font-weight: bold;
	display: none;
	}
</style>
@endpush
<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3>Student's Log Details</h3>
			<span class="count-circle" style="position:unset;" >{{ count($logs ) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get"  class="gap-2 d-block d-sm-flex ">				
				<input type="text" class="form-control  mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name"  placeholder="Search Student Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-info mt-2 mt-sm-0" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-hover">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
						<th>Name</th>
						<th>Contact Info</th>
						<th>Date & Time</th>
						<th>IP Address</th>
					</tr>
				</thead>
				<tbody>
					@if($logs->count() > 0)
					@foreach($logs as $log) 
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							@if($log->student)
								<a href="{{ route('admin.enrool-student-info',$log->student->id) }}" style="text-decoration: none;color:#334257;" class="title-color hover-c1 d-flex align-items-center gap-15">
								@if($log->student->image != null)
								<img src="{{ asset($log->student->image) }}" class="avatar rounded-circle"  height="50px" width="50px" alt="{{ asset($log->student->image) }}"  >
								@else 
								<img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle"  height="50px" width="50px" >
								@endif
								{{ $log->student->name }}
								</a>
							  @else
								<span class="text-danger">Student Not Found</span>
							@endif
						</td>
						<td>
							<div class="mb-1">
								<strong>
								<a href="mailto:{{ $log->student->email ?? 'N/A' }}" class="title-color hover-c1" style="font-weight:900;color:#334257;">{{ $log->student->email ?? 'N/A' }}</a>
								</strong>
							</div>
							<a href="tel:{{ $log->student->mobile ?? 'N/A' }}" style="color:#677788;text-decoration: none;background-color: transparent;cursor: pointer;" class="title-color hover-c1">{{ $log->student->mobile ?? 'N/A' }}</a>

                        </td>
						<td>
							{{ $log->time ?? 'N/A' }}
						</td>
						<td>
							{{ $log->ip ?? 'N/A' }}
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
			{{ $logs->links('pagination::bootstrap-4') }}
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