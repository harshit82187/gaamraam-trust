@extends('admin.layout.app')
@section('content')
@push('css')
<style>
	.pagination li {
		margin: 0 2px;
	}
</style>
@endpush
<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3>Visitor's Log Details</h3>
			<span class="count-circle" style="position:unset;">{{ count($logs ) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="date" class="form-control  mt-2 mt-sm-0" name="start_date" value="{{ request()->query('start_date', '') }}" placeholder="Start Date">
				<input type="date" class="form-control mt-2 mt-sm-0" name="end_date" value="{{ request()->query('end_date', '') }}" placeholder="End Date">
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
						<th>Token</th>
						<th>Date & Time</th>
						<th>IP Address</th>
					</tr>
				</thead>
				<tbody>
					@if($logs->count() > 0)
					@foreach($logs as $log)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $log->token ?? 'N/A' }}</td>
						<td>{{ $log->created_at ? $log->created_at->format('d-M-y h:i:s A') : 'N/A' }}</td>
						<td>{{ $log->ip ?? 'N/A' }} </td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="4" class="text-danger text-center">No Visitor Yet.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			<div class="mt-3">
				{{ $logs->onEachSide(1)->links('pagination::bootstrap-4') }}
			</div>
			<!-- {{ $logs->links('pagination::bootstrap-4') }} -->
		</div>
	</div>
</div>
@endsection
@push('js')

@endpush